<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class CalculatorController extends Controller
{
    public function index(): View
    {
        return view('calculators.index', [
            'calculators' => config('calculators.items'),
            'schema' => [Content::breadcrumbSchema([['Home', url('/')], ['Insurance calculators', route('calculators')]])],
        ]);
    }

    public function show(string $calculator): View
    {
        $item = config("calculators.items.{$calculator}");

        abort_unless($item, 404);

        return view('calculators.show', [
            'slug' => $calculator,
            'item' => $item,
            'product' => config("products.items.{$item['product']}"),
            'assumptions' => config('calculators.assumptions'),
            'others' => collect(config('calculators.items'))->except($calculator),
            'schema' => [
                [
                    '@type' => 'WebApplication',
                    'name' => $item['name'],
                    'applicationCategory' => 'FinanceApplication',
                    'operatingSystem' => 'Web',
                    'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'TTD'],
                    'description' => $item['description'],
                    'url' => route('calculators.show', $calculator),
                    'author' => ['@id' => url('/').'/#rachel-agostini'],
                ],
                Content::breadcrumbSchema([['Home', url('/')], ['Insurance calculators', route('calculators')], [$item['name'], route('calculators.show', $calculator)]]),
            ],
        ]);
    }
}
