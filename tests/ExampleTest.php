<?php

use Humayunjavaid\Payzen\Payzen;
use Illuminate\Http\Client\Response;
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

it('can generate token and psid response with required details', function () {

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

    Http::fake([
        'api/generatePsid/*' => Http::response(),
    ]);

    $response = app(Payzen::class)
        ->setConsumerName('test')
        ->setCnic('23232323')
        ->setEmail('sdsd@ad.com')
        ->setMobileNumber('232323')
        ->setChallanNumber('2323232323')
        ->setServiceId(12)
        ->setAccountNumber('32323')
        ->setAccountTitle('Wasa')
        ->setDueDate('2023-08-29')
        ->setExpiryDate('2023-08-29')
        ->setAmount(500)
        ->generate();

    expect($token)->toBe('generated-token');
    expect($response)->toBeInstanceOf(Response::class);
});
