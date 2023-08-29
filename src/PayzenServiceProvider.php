<?php

namespace Humayunjavaid\Payzen;

use Humayunjavaid\Payzen\Commands\PayzenCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PayzenServiceProvider extends PackageServiceProvider
{


    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-payzen')
            ->hasConfigFile();

        $this->app->bind('payzen', function () {

            $clientId = config('payzen.clientId');

            $clientSecretKey = config('payzen.clientSecretKey');

            $authUrl = config('payzen.authUrl');

            $psidUrl = config('payzen.psidUrl');

            return new Payzen($clientId, $clientSecretKey, $authUrl, $psidUrl);

        });
    }


}
