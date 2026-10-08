<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => route('products'), 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => route('calculators'), 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => route('quote'), 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('faq'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('contact'), 'priority' => '0.8', 'changefreq' => 'yearly'],
            ['loc' => route('privacy'), 'priority' => '0.2', 'changefreq' => 'yearly'],
        ];

        foreach (array_keys(config('products.items')) as $slug) {
            $urls[] = ['loc' => route('products.show', $slug), 'priority' => '0.8', 'changefreq' => 'monthly'];
        }

        foreach (array_keys(config('calculators.items')) as $slug) {
            $urls[] = ['loc' => route('calculators.show', $slug), 'priority' => '0.8', 'changefreq' => 'monthly'];
        }

        return response()->view('sitemap', ['urls' => $urls, 'lastmod' => now()->toDateString()])
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /leads',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines))->header('Content-Type', 'text/plain');
    }
}
