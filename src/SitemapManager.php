<?php

declare(strict_types=1);

namespace Ollico\Sitemap;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\URL;

class SitemapManager
{
    protected $items = [];

    protected $format = 'Y-m-d\TH:i:s';

    protected static ?Closure $registerCallback = null;

    protected ?string $pathToSitemap = null;

    public function addPath($path, $lastmod = null): SitemapManager
    {
        $this->items[] = [
            'url' => url($path, [], true),
            'lastmod' => $lastmod instanceof Carbon ? $lastmod->format($this->format) : $lastmod,
        ];

        return $this;
    }

    public function path(string $path): SitemapManager
    {
        $this->pathToSitemap = $path;

        return $this;
    }

    public function storagePath(): string
    {
        return $this->pathToSitemap ?: public_path('sitemap.xml');
    }

    public function register(Closure $callback): void
    {
        static::$registerCallback = $callback;
    }

    public function toArray(): array
    {
        URL::forceRootUrl(config('app.url'));

        if (static::$registerCallback) {
            call_user_func(static::$registerCallback, $this);
        }

        return $this->items;
    }

    public function toXml(): string
    {
        return view('sitemap::sitemap', ['items' => $this->toArray()])->render();
    }
}
