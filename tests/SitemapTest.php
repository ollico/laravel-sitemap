<?php

namespace Ollico\Sitemap\Tests;

use Carbon\Carbon;
use Ollico\Sitemap\Facades\Sitemap;
use Ollico\Sitemap\ServiceProvider;
use Ollico\Sitemap\SitemapManager;
use Orchestra\Testbench\TestCase;

class SitemapTest extends TestCase
{
    protected Carbon $dateOne;
    protected string $dateTwo;
    protected Carbon $dateThree;

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        app('config')->set('ollico.sitemap.enabled', true);
        app('config')->set('app.url', 'https://ollico.dev');

        $this->dateOne = now()->subDay();
        $this->dateTwo = '2021-01-01T10:10:10';
        $this->dateThree = now()->subDays(3);

        Sitemap::register(function (SitemapManager $manager) {
            $manager->addPath('/foo/bar', $this->dateOne);
            $manager->addPath('/bar/foo', $this->dateTwo);
            $manager->addPath('/bar/second', $this->dateThree);
        });
    }

    /** @test */
    function it_can_generate_a_sitemap()
    {
        $this->artisan('sitemap:generate')->assertSuccessful();

        $this->assertTrue(file_exists(public_path('sitemap.xml')));

        $content = file_get_contents(public_path('sitemap.xml'));

        $this->assertStringContainsString('https://ollico.dev/foo/bar', $content);
        $this->assertStringContainsString($this->dateOne->format('Y-m-d\TH:i:s'), $content);
        $this->assertStringContainsString('https://ollico.dev/bar/foo', $content);
        $this->assertStringContainsString($this->dateTwo, $content);
        $this->assertStringContainsString('https://ollico.dev/bar/second', $content);
        $this->assertStringContainsString($this->dateThree->format('Y-m-d\TH:i:s'), $content);
    }
}