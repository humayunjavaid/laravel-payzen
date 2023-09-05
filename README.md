# Payzen

[![Latest Version on Packagist](https://img.shields.io/packagist/v/humayunjavaid/laravel-payzen.svg?style=flat-square)](https://packagist.org/packages/humayunjavaid/laravel-payzen)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/humayunjavaid/laravel-payzen/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/humayunjavaid/laravel-payzen/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/humayunjavaid/laravel-payzen/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/humayunjavaid/laravel-payzen/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/humayunjavaid/laravel-payzen.svg?style=flat-square)](https://packagist.org/packages/humayunjavaid/laravel-payzen)

Streamline Payzen payment integration in Laravel. Generate Payment Service Identifiers (PSIDs) for P2G, P2P, B2G, and B2B payments with ease.

## Installation

You can install the package via composer:

```bash
composer require humayunjavaid/laravel-payzen
```
## Set Up Environment

Check your ```.env``` file, and ensure that your following parameters are set with valid credentials obtained from Payzen.

```
PAYZEN_CLIENT_ID
PAYZEN_CLIENT_SECRET_KEY
PAYZEN_AUTH_URL (Optional)
PAYZEN_PSID_URL (Optional)
```
Optionally you can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-payzen-config"
```

This is the contents of the published config file:

```php
return [

    'clientId' => env('PAYZEN_CLIENT_ID'),

    'clientSecretKey' => env('PAYZEN_CLIENT_SECRET_KEY'),

    'authUrl' => env('PAYZEN_AUTH_URL'),

    'psidUrl' => env('PAYZEN_PSID_URL'),

];
```
## Usage

```php
Payzen::setConsumerName('Dummy User')
    ->setCnic('123456789')
    ->setEmail('dummyuser@email.com')
    ->setMobileNumber('3324232321')
    ->setChallanNumber('2323232323')
    ->setServiceId('12')
    ->setAccountNumber('32323')
    ->setAccountTitle('Bibi Pak Damin')
    ->setDueDate('2023-08-29')
    ->setExpiryDate('2023-08-29')
    ->setAmountWithinDueDate(500)
    ->setAmountAfterDueDate(500)
    ->generate();
```
## Credits

-   [Humayun Javed](https://github.com/humayunjavaid)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
