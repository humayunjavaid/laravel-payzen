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
     *  Cnic
     */
    protected string $cnic;

    /**
     * Email
     */
    protected string $email;

    /**
     * Consumer Name
     */
    protected string $consumerName;

    /**
     * mobileNumber
     */
    protected string $mobileNumber;

    /**
     * Account Number
     */
    protected string $accountNumber;

    /**
     * Account Title
     */
    protected string $accountTitle;

    /**
     * Amount
     */
    protected string $amount;

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
        string $clientId = '',
        string $clientSecretKey = '',
        string $authUrl = '',
        string $psidUrl = ''
    ) {

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

        return $request->post($this->psidUrl, $this->payload());

    }

    public function payload(): array
    {
        return [
            'cnic' => $this->cnic,
            'consumerName' => $this->consumerName,
            'mobileNumber' => $this->mobileNumber ?? '',
            'challanNumber' => $this->challanNumber,
            'serviceId' => $this->serviceId,
            'dueDate' => $this->dueDate,
            'expiryDate' => $this->expiryDate,
            'amountWithinDueDate' => $this->amount,
            'amountAfterDueData' => $this->amount ?? '',
            'amountBifurcation' => [
                'accountHeadName' => $this->accountTitle,
                'accountNumber' => $this->accountNumber,
                'amountToTransfer' => $this->amount,
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
     * Amount to be set
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

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

    public function setCnic(string $cnic): self
    {
        $this->cnic = $cnic;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setMobileNumber(string $mobileNumber): self
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }
}
