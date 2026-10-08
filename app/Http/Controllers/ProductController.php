<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index', [
            'groups' => Content::productGroups(),
            'excluded' => config('products.excluded'),
            'schema' => [Content::breadcrumbSchema([['Home', url('/')], ['Insurance products', route('products')]])],
        ]);
    }

    public function show(string $product): View
    {
        $item = config("products.items.{$product}");

        abort_unless($item, 404);

        $related = collect(config('products.items'))
            ->except($product)
            ->filter(fn ($other) => $other['group'] === $item['group'])
            ->take(3);

        if ($related->count() < 3) {
            $related = $related->merge(collect(config('products.items'))->except($product)->take(3 - $related->count()));
        }

        $calculator = $item['calculator'] ? config("calculators.items.{$item['calculator']}") : null;

        return view('products.show', [
            'slug' => $product,
            'item' => $item,
            'related' => $related,
            'calculator' => $calculator,
            'schema' => [
                [
                    '@type' => 'Service',
                    'name' => $item['name'],
                    'serviceType' => $item['name'],
                    'description' => $item['summary'],
                    'provider' => ['@id' => url('/').'/#agency'],
                    'brand' => ['@type' => 'Brand', 'name' => $item['company']],
                    'areaServed' => ['@type' => 'Country', 'name' => 'Trinidad and Tobago'],
                    'url' => route('products.show', $product),
                    'hasOfferCatalog' => [
                        '@type' => 'OfferCatalog',
                        'name' => $item['name'].' plans',
                        'itemListElement' => array_map(fn ($plan) => [
                            '@type' => 'Offer',
                            'itemOffered' => ['@type' => 'Service', 'name' => $plan['name'], 'description' => $plan['blurb']],
                        ], $item['plans']),
                    ],
                ],
                Content::breadcrumbSchema([['Home', url('/')], ['Insurance products', route('products')], [$item['name'], route('products.show', $product)]]),
            ],
        ]);
    }
}
