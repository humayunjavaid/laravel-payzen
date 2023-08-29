<?php

namespace Humayunjavaid\Payzen;

use Humayunjavaid\Payzen\Commands\PayzenCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PayzenServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-payzen')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-payzen_table')
            ->hasCommand(PayzenCommand::class);
    }
}
