<?php

declare(strict_types=1);

namespace IllumaLaw\HealthCheckMercure\Tests;

use IllumaLaw\HealthCheckMercure\HealthcheckMercureServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Health\HealthServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            HealthServiceProvider::class,
            HealthcheckMercureServiceProvider::class,
        ];
    }
}
