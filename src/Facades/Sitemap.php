<?php

namespace Ollico\Sitemap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void register(\Closure $sitemapManager)
 * @method static \Ollico\Sitemap\SitemapManager path(string $path)
 *
 * @see \Ollico\Sitemap\SitemapManager
 */
class Sitemap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Ollico\Sitemap\SitemapManager::class;
    }
}
