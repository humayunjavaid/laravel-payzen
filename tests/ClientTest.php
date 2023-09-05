<?php

use Humayunjavaid\Payzen\Exceptions\ClientIdRequiredException;
use Humayunjavaid\Payzen\Exceptions\ClientSecretKeyRequiredException;
use Humayunjavaid\Payzen\Payzen;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config([
        'payzen.clientId' => 'fake-clientId',
        'payzen.clientSecretKey' => 'fake-clientSecretKey'
    ]);
});

it('throws client id exception ' , function(){
    config(['payzen.clientId' => null]);
    throw new ClientIdRequiredException;
})->throws(ClientIdRequiredException::class , 'Client id is required');

it('throws client secret key exception ' , function(){
    config(['payzen.clienSecretKey' => null]);
    throw new ClientSecretKeyRequiredException;
})->throws(ClientSecretKeyRequiredException::class , 'Client secret key is required');


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
        'genratePSID/*' => Http::response(),
    ]);

    $response = app(Payzen::class)
        ->setConsumerName('test')
        ->setCnic('232')
        ->setEmail('223@adas.com')
        ->setMobileNumber('2323')
        ->setChallanNumber('2323232323')
        ->setServiceId('12')
        ->setAccountNumber('32323')
        ->setAccountTitle('Wasa')
        ->setDueDate('2023-08-29')
        ->setExpiryDate('2023-08-29')
        ->setAmountWithinDueDate(500)
        ->setAmountAfterDueDate(600)
        ->generate();

    expect($token)->toBe('generated-token');
    expect($response)->toBeInstanceOf(Response::class);
});
