<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Product;
use App\Models\Store;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        // Static pages
        foreach ([
            ['/', 'home'],
            ['/about', 'about'],
            ['/products', 'products.index'],
            ['/events', 'events.index'],
            ['/events/archive', 'events.archive'],
            ['/stores', 'stores.index'],
            ['/reviews', 'reviews.index'],
            ['/contact', 'contact'],
            ['/privacy-policy', 'privacy'],
            ['/terms', 'terms'],
        ] as [$path, $name]) {
            $urls[] = [
                'url' => route($name),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => match ($name) {
                    'home' => '1.0',
                    'products.index', 'events.index', 'stores.index' => '0.9',
                    default => '0.7',
                },
            ];
        }

        // Dynamic products
        Product::active()->latest()->chunk(1000, function ($products) use (&$urls) {
            foreach ($products as $p) {
                $urls[] = [
                    'url' => route('products.show', $p),
                    'lastmod' => $p->updated_at->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.8',
                ];
            }
        });

        // Dynamic stores
        Store::active()->latest()->chunk(1000, function ($stores) use (&$urls) {
            foreach ($stores as $s) {
                $urls[] = [
                    'url' => route('stores.show', $s),
                    'lastmod' => $s->updated_at->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.8',
                ];
            }
        });

        // Dynamic events (published only)
        Event::visible()->latest()->chunk(1000, function ($events) use (&$urls) {
            foreach ($events as $e) {
                $urls[] = [
                    'url' => route('events.show', $e),
                    'lastmod' => $e->updated_at->toAtomString(),
                    'changefreq' => $e->status === 'past' ? 'yearly' : 'weekly',
                    'priority' => '0.7',
                ];
            }
        });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        foreach ($urls as $item) {
            $xml .= '    <url>' . PHP_EOL;
            $xml .= '        <loc>' . e($item['url']) . '</loc>' . PHP_EOL;
            $xml .= '        <lastmod>' . $item['lastmod'] . '</lastmod>' . PHP_EOL;
            $xml .= '        <changefreq>' . $item['changefreq'] . '</changefreq>' . PHP_EOL;
            $xml .= '        <priority>' . $item['priority'] . '</priority>' . PHP_EOL;
            $xml .= '    </url>' . PHP_EOL;
        }
        $xml .= '</urlset>';

        return response($xml)->header('Content-Type', 'application/xml');
    }
}