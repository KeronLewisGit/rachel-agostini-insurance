<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class PageController extends Controller
{
    /** The home page, including the "where should I start?" recommender paths. */
    public function home(): View
    {
        $paths = [
            'parent' => ['label' => 'I just became a parent', 'icon' => 'baby', 'title' => 'Cover the income first, then the education.', 'text' => 'A term or whole life policy sized to replace your income until your child is independent, critical illness so a diagnosis does not drain the house, and an education plan that keeps paying even if you cannot.', 'products' => ['life-insurance', 'critical-illness', 'education-savings'], 'calculator' => 'life-cover'],
            'self' => ['label' => 'I am self-employed', 'icon' => 'briefcase', 'title' => 'Nobody pays you when you are off. Plan for that.', 'text' => 'Critical illness and personal accident cover replace the income that stops the day you do. A registered annuity gives you the pension and the tax deduction an employer never set up for you.', 'products' => ['critical-illness', 'personal-accident', 'pensions-annuities'], 'calculator' => 'critical-illness'],
            'business' => ['label' => 'I run a business', 'icon' => 'building-2', 'title' => 'Protect the premises, the people and the owner.', 'text' => 'FireGuard, liability and money cover from Guardian General for the business itself, group life and health to keep good staff, and key-person life cover on you.', 'products' => ['business-insurance', 'employee-benefits', 'life-insurance'], 'calculator' => null],
            'retire' => ['label' => 'I am thinking about retirement', 'icon' => 'piggy-bank', 'title' => 'Turn this year\'s tax bill into next decade\'s income.', 'text' => 'A Lifestyle Pension or registered annuity is deductible against income tax now and pays you from any age between 52 and 70. Add health cover that still works when the group plan ends.', 'products' => ['pensions-annuities', 'investments', 'health-insurance'], 'calculator' => 'retirement'],
            'travel' => ['label' => 'I travel or own a boat', 'icon' => 'plane', 'title' => 'Short policies, confirmed the same day.', 'text' => 'Single-trip or annual travel cover with medical expenses abroad, MarineGuard for the vessel and your liability, and Pet Guard if the dog stays home.', 'products' => ['travel-insurance', 'marine-insurance', 'pet-insurance'], 'calculator' => null],
        ];

        return view('pages.home', [
            'paths' => $paths,
            'groups' => Content::productGroups(),
            'featured' => collect(config('products.items'))->only(['life-insurance', 'critical-illness', 'pensions-annuities', 'health-insurance', 'education-savings', 'business-insurance']),
            'calculators' => config('calculators.items'),
            'faqs' => array_slice(config('site.faqs'), 0, 4),
            'schema' => [Content::faqSchema(array_slice(config('site.faqs'), 0, 4))],
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'schema' => [Content::breadcrumbSchema([['Home', url('/')], ['About Rachel', route('about')]])],
        ]);
    }

    public function faq(): View
    {
        $faqs = config('site.faqs');

        return view('pages.faq', [
            'faqs' => $faqs,
            'schema' => [Content::faqSchema($faqs), Content::breadcrumbSchema([['Home', url('/')], ['FAQ', route('faq')]])],
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'products' => collect(config('products.items'))->map(fn ($item) => $item['name'])->all(),
            'schema' => [Content::breadcrumbSchema([['Home', url('/')], ['Contact', route('contact')]])],
        ]);
    }

    public function quote(): View
    {
        return view('pages.quote', [
            'products' => collect(config('products.items'))->map(fn ($item) => $item['name'])->all(),
            'preselected' => request()->query('product'),
            'schema' => [Content::breadcrumbSchema([['Home', url('/')], ['Get a quote', route('quote')]])],
        ]);
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }
}
