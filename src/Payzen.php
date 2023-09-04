<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen;

use Exception;
use Humayunjavaid\Payzen\Validators\ValidatorFactory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 *  Payzen
 */
class Payzen
{
    /**
     * Client Id provided by payzen
     */
    protected string $clientId;

    /**
     * Client Secrect Key
     */
    protected string $clientSecretKey;

    /**
     * Authentication Url
     */
    protected string $authUrl;

    /**
     *  psidUrl
     */
    protected string $psidUrl;

    /**
     * Token
     */
    protected string $token;

    /**
     * CNIC
     */
    protected string $cnic;

    /**
     * Email
     */
    protected ?string $email = null;

    /**
     * Consumer Name
     */
    protected string $consumerName;

    /**
     * mobileNumber
     */
    protected ?string $mobileNumber = null;

    /**
     * Account Number
     */
    protected string $accountNumber;

    /**
     * Account Title
     */
    protected string $accountTitle;

    /**
     * Amount Within Due Date
     */
    protected int $amountWithinDueDate;

    /**
     * Amount After Due Date
     */
    protected int $amountAfterDueDate;

    /**
     * Due Date
     */
    protected string $dueDate;

    /**
     * Expiry Date
     */
    protected string $expiryDate;

    /**
     * Challan Number
     */
    protected string $challanNumber;

    /**
     * Service ID
     */
    protected string $serviceId;

    public function __construct(
        string $clientId,
        string $clientSecretKey,
        string $authUrl,
        string $psidUrl
    ) {

        if (empty($clientId)) {
            throw new Exception('Client id is required');
        }

        if (empty($clientSecretKey)) {
            throw new Exception('Client secret key is required');
        }

        if (empty($authUrl)) {
            throw new Exception('Authentication url is required');
        }

        if (empty($psidUrl)) {
            throw new Exception('PSID url is required');
        }

        $this->clientId = $clientId;

        $this->clientSecretKey = $clientSecretKey;

        $this->authUrl = $authUrl;

        $this->psidUrl = $psidUrl;

        $this->token = self::generateToken();

    }

    /**
     * Generate Psid and return response
     */
    public function generate(): Response
    {
        $validator = ValidatorFactory::createValidator();

        $validator->validate($this->payload());

        $request = $this->createRequest();

        return $request->post($this->psidUrl, $validator->getValidatedData());

    }

    public function payload(): array
    {
        return [
            'cnic' => $this->cnic,
            'consumerName' => $this->consumerName,
            'email' => $this->email,
            'mobileNumber' => $this->mobileNumber,
            'challanNumber' => $this->challanNumber,
            'serviceId' => $this->serviceId,
            'dueDate' => $this->dueDate,
            'expiryDate' => $this->expiryDate,
            'amountWithinDueDate' => $this->amountWithinDueDate,
            'amountAfterDueDate' => $this->amountAfterDueDate,
            'amountBifurcation' => [
                [
                    'accountHeadName' => $this->accountTitle,
                    'accountNumber' => $this->accountNumber,
                    'amountToTransfer' => $this->amountWithinDueDate,
                ],
            ],
        ];
    }

    /**
     * Generate and retrieve the authentication token
     */
    public function generateToken(): string
    {

        $response = Http::withHeaders([
            'Content-type: application/vnd.api+json',
            'Accept: application/vnd.api+json',
        ])
            ->post($this->authUrl, [
                'clientId' => $this->clientId,
                'clientSecretKey' => $this->clientSecretKey,
            ]);

        if (! $response->successful()) {
            throw new Exception('Failed to generate token');
        }

        $data = $response->json();

        $this->token = data_get($data, 'content.0.token.token', '');

        if (! $this->token) {
            throw new Exception('Token not received in the response');
        }

        return $this->token;
    }

    /**
     * Build Http Request.
     */
    private function createRequest(): PendingRequest
    {
        $request = Http::withToken($this->token)
            ->withHeaders([
                'Content-type: application/vnd.api+json',
                'Accept: application/vnd.api+json',
            ]);

        return $request;
    }

    /**
     * Account Number of merchant
     */
    public function setAccountNumber(string $accountNumber): self
    {

        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Account title of merchant
     */
    public function setAccountTitle(string $accountTitle): self
    {
        $this->accountTitle = $accountTitle;

        return $this;
    }

    /**
     * Due date of payable amount
     */
    public function setDueDate(string $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Expiry Date of payable amount
     */
    public function setExpiryDate(string $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Client generated challanNumber required for payment intimation
     */
    public function setChallanNumber(string $challanNumber): self
    {
        $this->challanNumber = $challanNumber;

        return $this;
    }

    /**
     * Service ID provided by Payzen
     */
    public function setServiceId(string $serviceId): self
    {
        $this->serviceId = $serviceId;

        return $this;
    }

    public function setConsumerName(string $consumerName): self
    {

        $this->consumerName = $consumerName;

        return $this;
    }

    /**
     * Amount Within Due Date
     *
     * @param  int  $amountWithinDueDate Amount Within Due Date
     */
    public function setAmountWithinDueDate(int $amountWithinDueDate): self
    {
        $this->amountWithinDueDate = $amountWithinDueDate;

        return $this;
    }

    /**
     * mobileNumber
     *
     * @param  string|null  $mobileNumber mobileNumber
     */
    public function setMobileNumber(string $mobileNumber = null): self
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    /**
     * Email
     *
     * @param  string|null  $email Email
     */
    public function setEmail(string $email = null): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Amount After Due Date
     *
     * @param  int  $amountAfterDueDate Amount After Due Date
     */
    public function setAmountAfterDueDate(int $amountAfterDueDate): self
    {
        $this->amountAfterDueDate = $amountAfterDueDate;

        return $this;
    }

    /**
     * CNIC
     *
     * @param  string  $cnic CNIC
     */
    public function setCnic(string $cnic): self
    {
        $this->cnic = $cnic;

        return $this;
    }
}
