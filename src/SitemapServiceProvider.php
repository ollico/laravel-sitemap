<?php

namespace Ollico\Sitemap;

use Ollico\Utilities\Sitemap\Commands\CacheSitemapCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SitemapServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-sitemap')
            ->hasConfigFile()
            ->hasViews()
            ->publishesServiceProvider()
            ->hasCommand(CacheSitemapCommand::class);
    }
}
