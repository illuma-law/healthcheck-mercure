<?php

declare(strict_types=1);

namespace IllumaLaw\HealthCheckMercure;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class HealthcheckMercureServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('healthcheck-mercure')
            ->hasConfigFile()
            ->hasTranslations();
    }
}
