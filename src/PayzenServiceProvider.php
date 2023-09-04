<?php

declare(strict_types=1);

namespace Humayunjavaid\Payzen;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PayzenServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {

        $package
            ->name('laravel-payzen')
            ->hasConfigFile('payzen');

        $this->app->bind(Payzen::class, function () {
            return new Payzen(
                config('payzen.clientId'),
                config('payzen.clientSecretKey'),
                config('payzen.authUrl'),
                config('payzen.psidUrl')
            );

        });
    }
}
