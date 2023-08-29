<?php

use Humayunjavaid\Payzen\Payzen;
use Illuminate\Support\Facades\Http;

it('generates a token', function () {

    Http::fake([
        '*' => Http::response([
            'content' => [
                0 => [
                    'token' => [
                        'token' => 'generated-token',
                    ],
                ],
            ],
        ], 200),
    ]);

    $token = app(Payzen::class)->generateToken();

    expect($token)->toBe('generated-token');
});

it('can generate psid response with required details', function () {

    Http::fake([
        '*' => Http::response([
            'content' => [
                0 => [
                    'consumerNumber' => 'consumer-number',
                    'consumerKey' => 'consumer-key',
                    'challanAmount' => 'challan-amount',
                    'service_charges' => 'service-charges',
                ],
            ],
        ], 200),
    ]);

    $token = app(Payzen::class)->generateToken();

    $response = app(Payzen::class)->generate();

    // Assertions
    // Http::assertSent(function ($request) use ($clientId, $clientSecretKey , $authUrl) {
    //     return $request->url() === $authUrl
    //         && $request['clientId'] === $clientId
    //         && $request['clientSecretKey'] === $clientSecretKey;
    // });

    expect($response)->toBeInstanceOf(Response::class);
    expect($response)->toBeInstanceOf(Response::class);
});
