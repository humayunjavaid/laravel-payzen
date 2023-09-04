<?php

return [

    /**
     * Client Id provided by payzen
     */
    'clientId' => env('PAYZEN_CLIENT_ID'),

    /**
     * Client secret key provided by payzen
     */
    'clientSecretKey' => env('PAYZEN_CLIENT_SECRET_KEY'),

    /**
     * Auth Url provided by payzen to generate token
     */
    'authUrl' => env('PAYZEN_AUTH_URL', 'https://api.payzen.pk:8445/payzen/api/auth/authenticate'),

    /**
     * Psid Url provided by payzen to genrate PSID
     */
    'psidUrl' => env('PAYZEN_PSID_URL', 'https://api.payzen.pk:8445/payzen/api/psid'),

];
