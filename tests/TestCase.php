<?php

namespace Lahirulhr\PayHere\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lahirulhr\PayHere\PayHereServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Lahirulhr\\PayHere\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            PayHereServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-payhere_table.php.stub';
        $migration->up();
        */
    }
}
