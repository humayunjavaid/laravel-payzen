<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen;

use Exception;
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
     *  userData
     */
    protected array $userData;

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

    public function psid(): Payzen
    {
        return new self();
    }

    /**
     * Generate Psid and return response
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
            'amountBifurcation' => [],
        ];

        $request = $this->createRequest();

        return $request->post($this->psidUrl, $payload);

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
                'clientSecretKey' => $this->clientSecretKey
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

    public function setUserData(array $userData): self
    {
        $this->userData = $userData;

        return $this;
    }

    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function setAccountTitle(string $accountTitle): self
    {
        $this->accountTitle = $accountTitle;

        return $this;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function setDueDate(string $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function setExpiryDate(string $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function setChallanNumber(string $challanNumber): self
    {
        $this->challanNumber = $challanNumber;

        return $this;
    }

    public function setServiceId(string $serviceId): self
    {
        $this->serviceId = $serviceId;

        return $this;
    }
}
