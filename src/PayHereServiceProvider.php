<?php

namespace Lahirulhr\PayHere;

use Lahirulhr\PayHere\Commands\PayHereCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PayHereServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-payhere')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-payhere_table')
            ->hasCommand(PayHereCommand::class);
    }
}
