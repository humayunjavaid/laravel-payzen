<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;


/**
 *  Payzen
 */
class Payzen
{
    /**
     * Client Id provided by payzen
     * @var string
     */
    protected string $clientId;


    /**
     * Client Secrect Key
     * @var string
     */
    protected string $clientSecretKey;


    /**
     * Authentication Url
     *
     * @var string
     */
    protected string $authUrl;


    /**
     *  psidUrl
     * @var string
     */
    protected string $psidUrl;

    /**
     * Token
     * @var string
     */
    protected string $token;


    /**
     *  userData
     * @var array
     */
    protected array $userData;

    /**
     * Account Number
     * @var string
     */
    protected string $accountNumber;

    /**
     * Account Title
     * @var string
     */
    protected string $accountTitle;

    /**
     * Amount
     * @var string
     */
    protected string $amount;

    /**
     * Due Date
     * @var string
     */
    protected string $dueDate;

    /**
     * Expiry Date
     * @var string
     */
    protected string $expiryDate;

    /**
     * Challan Number
     * @var string
     */
    protected string $challanNumber;

    /**
     * Service ID
     * @var string
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
     * @return Payzen
     */
    public function psid(): Payzen
    {
        return new self();
    }


    /**
     * Generate Psid and return response
     * @return Response
     */
    public function generate(): Response
    {

        $payload = [
            'challanNumber' => $this->challanNumber,
            'serviceId' => $this->serviceId,
            'dueDate' => $this->dueDate ?? '',
            'expiryDate' => $this->expiryDate ?? '',
            'amountWithinDueDate' => $this->amount,
            'amountAfterDueData' => $this->amount ?? '',
            'amountBifurcation' => []
        ];

        $request = $this->createRequest();

        return $request->post($this->psidUrl, $payload);

    }


    /**
     * Generate and retrieve the authentication token
     * @return string
     */
    public function generateToken(): string
    {
        $response = Http::withHeaders([
            'Content-type: application/vnd.api+json',
            'Accept: application/vnd.api+json',
        ])
            ->post($this->authUrl, [
                'clientId' => $this->clientId,
                'clientSecretKey' => $this->clientSecretKey
            ]);

        if (!$response->successful()) {
            throw new Exception("Failed to generate token");
        }

        $data = $response->json();

        $this->token = data_get($data, 'content.0.token.token', '');

        if (!$this->token) {
            throw new Exception("Token not received in the response");
        }

        return $this->token;
    }

    /**
     * Build Http Request.
     * @return PendingRequest
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
     * @param array $userData
     * @return self
     */
    public function setUserData(array $userData): self
    {
        $this->userData = $userData;
        return $this;
    }

    /**
     * @param string $accountNumber
     * @return self
     */
    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @param string $accountTitle
     * @return self
     */
    public function setAccountTitle(string $accountTitle): self
    {
        $this->accountTitle = $accountTitle;
        return $this;
    }

    /**
     * @param string $amount
     * @return self
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param string $dueDate
     * @return self
     */
    public function setDueDate(string $dueDate): self
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @param string $expiryDate
     * @return self
     */
    public function setExpiryDate(string $expiryDate): self
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    /**
     * @param string $challanNumber
     * @return self
     */
    public function setChallanNumber(string $challanNumber): self
    {
        $this->challanNumber = $challanNumber;
        return $this;
    }

    /**
     * @param string $serviceId
     * @return self
     */
    public function setServiceId(string $serviceId): self
    {
        $this->serviceId = $serviceId;
        return $this;
    }
}
