<?php

declare(strict_types=1);

namespace Ollico\Sitemap\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Ollico\Sitemap\SitemapManager;

class CacheSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Cache the sitemap';

    public function handle(SitemapManager $sitemap)
    {
        if (config('ollico.sitemap.enabled')) {
            File::put($sitemap->storagePath(), $sitemap->toXml());
        }
    }
}
