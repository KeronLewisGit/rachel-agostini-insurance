<?php

namespace App\Support;

use Illuminate\Support\Str;

class Content
{
    /** @var array<string, string> */
    protected static array $icons = [];

    /** Inline a Lucide icon from resources/icons. */
    public static function icon(string $name, string $class = 'size-5', string $attributes = ''): string
    {
        if (! isset(self::$icons[$name])) {
            $path = resource_path("icons/{$name}.svg");
            $svg = is_file($path) ? file_get_contents($path) : '<svg viewBox="0 0 24 24"></svg>';
            $svg = preg_replace('/<!--.*?-->/s', '', $svg);
            $svg = preg_replace_callback('/<svg\b[^>]*>/', fn (array $tag) => preg_replace('/\s(class|width|height)="[^"]*"/', '', $tag[0]), $svg, 1);
            self::$icons[$name] = trim(preg_replace('/\s+/', ' ', $svg));
        }

        return str_replace('<svg', '<svg class="'.e($class).'" aria-hidden="true" '.$attributes, self::$icons[$name]);
    }

    /** A wa.me link to Rachel, optionally with a pre-filled message. */
    public static function whatsapp(?string $message = null): string
    {
        return 'https://wa.me/'.config('site.whatsapp').($message ? '?text='.rawurlencode($message) : '');
    }

    /** Format a TT$ amount for display. */
    public static function money(int|float|null $amount, string $currency = 'TT$'): string
    {
        return $currency.number_format((float) $amount, 0);
    }

    /**
     * Products grouped for navigation and the products page.
     *
     * @return array<string, array{name: string, blurb: string, items: array<string, array<string, mixed>>}>
     */
    public static function productGroups(): array
    {
        $groups = config('products.groups');

        foreach ($groups as $key => &$group) {
            $group['items'] = array_filter(config('products.items'), fn ($item) => $item['group'] === $key);
        }

        return $groups;
    }

    /**
     * Structured data shared by every page: the agent, the business and the website.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function baseSchema(): array
    {
        $site = config('site');
        $url = url('/');

        $person = [
            '@type' => 'Person',
            '@id' => $url.'/#rachel-agostini',
            'name' => 'Rachel Agostini',
            'jobTitle' => 'Insurance Sales Representative',
            'worksFor' => [
                '@type' => 'Organization',
                'name' => 'Guardian Life of the Caribbean Limited',
                'url' => $site['links']['guardian'],
            ],
            'image' => asset($site['seo']['image']),
            'telephone' => $site['phone_href'],
            'email' => $site['email'],
            'url' => $url,
            'sameAs' => [$site['links']['instagram']],
            'award' => 'TTAIFA National Awardee 2024, Ruby Production Award',
            'knowsAbout' => ['Life insurance', 'Critical illness insurance', 'Pensions and annuities', 'Health insurance', 'Business insurance'],
        ];

        $agency = [
            '@type' => 'InsuranceAgency',
            '@id' => $url.'/#agency',
            'name' => 'Rachel Agostini, Guardian Life of the Caribbean Sales Representative',
            'alternateName' => 'Rachel Agostini Insurance',
            'url' => $url,
            'logo' => asset('images/mark.svg'),
            'image' => asset($site['seo']['image']),
            'telephone' => $site['phone_href'],
            'email' => $site['email'],
            'priceRange' => 'Free consultation',
            'areaServed' => ['@type' => 'Country', 'name' => 'Trinidad and Tobago'],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $site['address']['locality'],
                'addressRegion' => $site['address']['region'],
                'addressCountry' => $site['address']['country'],
            ],
            'founder' => ['@id' => $url.'/#rachel-agostini'],
            'employee' => ['@id' => $url.'/#rachel-agostini'],
            'parentOrganization' => ['@type' => 'Organization', 'name' => 'Guardian Group', 'url' => $site['links']['guardian']],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '08:00',
                'closes' => '18:00',
            ],
            'sameAs' => [$site['links']['instagram']],
            'makesOffer' => array_values(array_map(fn ($item, $slug) => [
                '@type' => 'Offer',
                'itemOffered' => ['@type' => 'Service', 'name' => $item['name'], 'url' => route('products.show', $slug)],
            ], config('products.items'), array_keys(config('products.items')))),
        ];

        $website = [
            '@type' => 'WebSite',
            '@id' => $url.'/#website',
            'url' => $url,
            'name' => $site['brand'],
            'publisher' => ['@id' => $url.'/#agency'],
            'inLanguage' => 'en-TT',
        ];

        return [$agency, $person, $website];
    }

    /**
     * @param  array<int, array{0: string, 1: string}>  $crumbs  [name, url]
     * @return array<string, mixed>
     */
    public static function breadcrumbSchema(array $crumbs): array
    {
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(fn ($crumb, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $crumb[0],
                'item' => $crumb[1],
            ], $crumbs, array_keys($crumbs)),
        ];
    }

    /**
     * @param  array<int, array{q: string, a: string}>  $faqs
     * @return array<string, mixed>
     */
    public static function faqSchema(array $faqs): array
    {
        return [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
            ], $faqs),
        ];
    }

    public static function excerpt(string $text, int $length = 155): string
    {
        return Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($text))), $length, '…');
    }
}
