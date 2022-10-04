<?php

namespace Ollico\Sitemap;

use Ollico\Sitemap\Commands\CacheSitemapCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ServiceProvider extends PackageServiceProvider
{
    public function packageRegistered(): void
    {
        $this->app->singleton(SitemapManager::class, function () {
            return new SitemapManager();
        });
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-sitemap')
            ->hasConfigFile()
            ->hasViews()
            ->publishesServiceProvider('SitemapServiceProvider')
            ->hasCommand(CacheSitemapCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $command->info('Installing ollico/laravel-sitemap');
                    })
                    ->publishConfigFile()
                    ->copyAndRegisterServiceProviderInApp()
                    ->endWith(function (InstallCommand $command) {
                        $command->info('Completed installation of ollico/laravel-sitemap');
                    });
            });
    }
}
