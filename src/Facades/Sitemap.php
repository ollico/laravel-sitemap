<?php

namespace Ollico\Sitemap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void register(\Closure $sitemapManager)
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
