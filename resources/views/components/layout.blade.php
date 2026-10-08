@props(['title' => null, 'description' => null, 'schema' => [], 'image' => null, 'noindex' => false])
@php
    $site = config('site');
    $current = Route::currentRouteName();
    $groups = \App\Support\Content::productGroups();
    $calculators = config('calculators.items');
    // Titles that already carry Rachel's name (product and calculator SEO titles) stand alone; others get the brand suffix.
    $pageTitle = match (true) {
        ! $title => $site['title_suffix'],
        str_contains($title, 'Rachel Agostini') => $title,
        default => $title.' | Rachel Agostini · Guardian Life of the Caribbean, Trinidad & Tobago',
    };
    $metaDescription = \App\Support\Content::excerpt($description ?? $site['seo']['default_description'], 160);
    $ogImage = asset($image ?? $site['seo']['image']);
    $canonical = url()->current();
    $jsonLd = ['@context' => 'https://schema.org', '@graph' => array_merge(\App\Support\Content::baseSchema(), $schema)];
    $whatsapp = \App\Support\Content::whatsapp('Hi Rachel, I found your website and would like to talk about insurance.');
    $links = [
        ['calculators', 'Calculators', ['calculators', 'calculators.show']],
        ['about', 'About Rachel', ['about']],
        ['faq', 'FAQ', ['faq']],
        ['contact', 'Contact', ['contact']],
    ];
@endphp
<!DOCTYPE html>
<html lang="en-TT">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ implode(', ', $site['seo']['keywords']) }}">
    <meta name="author" content="Rachel Agostini">
    <meta name="robots" content="{{ $noindex ? 'noindex, nofollow' : 'index, follow, max-image-preview:large' }}">
    <meta name="geo.region" content="TT">
    <meta name="geo.placename" content="Trinidad and Tobago">
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $site['brand'] }}">
    <meta property="og:locale" content="en_TT">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="Rachel Agostini, Guardian Life of the Caribbean sales representative in Trinidad and Tobago">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    <meta name="theme-color" content="#0a1430">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/mark.svg') }}">
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap') }}">
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col" x-data="{ menu: false }" :class="menu && 'overflow-hidden'" @keydown.escape.window="menu = false">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[60] focus:rounded-full focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-semibold">Skip to content</a>

    {{-- Utility bar --}}
    <div class="bg-ink text-white">
        <div class="wrap flex h-10 items-center justify-between gap-4 text-xs">
            <p class="flex min-w-0 items-center gap-2 text-white/70">
                <x-icon name="badge-check" class="size-3.5 shrink-0 text-gold-300" />
                <span class="truncate">Guardian Life of the Caribbean sales representative <span class="hidden sm:inline">&middot; Central Bank registered &middot; TTAIFA National Awardee 2024</span></span>
            </p>
            <div class="flex shrink-0 items-center gap-5">
                <a href="mailto:{{ $site['email'] }}" class="hidden items-center gap-1.5 text-white/80 transition hover:text-white md:flex"><x-icon name="mail" class="size-3.5" /> {{ $site['email'] }}</a>
                <a href="tel:{{ $site['phone_href'] }}" class="hidden items-center gap-1.5 font-semibold transition hover:text-gold-300 sm:flex"><x-icon name="phone" class="size-3.5" /> {{ $site['phone'] }}</a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="flex items-center gap-1 font-semibold transition hover:text-gold-300">WhatsApp Rachel <x-icon name="arrow-up-right" class="size-3.5" /></a>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="sticky top-0 z-40 border-b border-line/80 bg-paper/90 backdrop-blur-lg">
        <div class="wrap flex h-[4.5rem] items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="shrink-0" aria-label="Rachel Agostini home">
                <x-logo />
            </a>

            <nav class="hidden items-center gap-1 lg:flex" aria-label="Main">
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @focusout="if (! $el.contains($event.relatedTarget)) open = false">
                    <a href="{{ route('products') }}" @focus="open = true" class="flex items-center gap-1 rounded-full px-3.5 py-2 text-sm font-semibold transition hover:bg-ink/5 {{ in_array($current, ['products', 'products.show']) ? 'text-brand-700' : 'text-ink' }}" :aria-expanded="open">
                        Insurance <x-icon name="chevron-down" class="size-3.5 opacity-50 transition" ::class="open && 'rotate-180'" />
                    </a>
                    <div x-cloak x-show="open" x-transition.origin.top.duration.150ms class="absolute top-full left-1/2 w-[46rem] -translate-x-1/2 pt-3">
                        <div class="grid grid-cols-3 gap-2 rounded-3xl bg-white p-3 shadow-lift ring-1 ring-line">
                            @foreach ($groups as $group)
                                <div class="rounded-2xl bg-paper/60 p-3">
                                    <p class="px-2 pb-2 text-[11px] font-bold tracking-[0.16em] text-brand-700 uppercase">{{ $group['name'] }}</p>
                                    @foreach ($group['items'] as $slug => $item)
                                        <a href="{{ route('products.show', $slug) }}" class="group flex items-center gap-2.5 rounded-xl px-2 py-2 text-sm font-semibold transition hover:bg-white hover:text-brand-700">
                                            <x-icon :name="$item['icon']" class="size-4 text-muted transition group-hover:text-brand-700" /> {{ $item['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                            <a href="{{ route('products') }}" class="col-span-3 flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-bold transition hover:bg-paper hover:text-brand-700">All insurance products <x-icon name="arrow-right" class="size-4" /></a>
                        </div>
                    </div>
                </div>
                @foreach ($links as [$route, $label, $active])
                    <a href="{{ route($route) }}" class="rounded-full px-3.5 py-2 text-sm font-semibold transition hover:bg-ink/5 {{ in_array($current, $active) ? 'text-brand-700' : '' }}">{{ $label }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('quote') }}" class="btn btn-primary hidden !py-2.5 sm:inline-flex">Get a quote</a>
                <button type="button" class="grid size-10 place-items-center rounded-full bg-ink text-white lg:hidden" @click="menu = true" aria-label="Open menu">
                    <x-icon name="menu" class="size-[18px]" />
                </button>
            </div>
        </div>
    </header>

    {{-- Mobile menu --}}
    <div x-cloak x-show="menu" x-transition.opacity class="fixed inset-0 z-50 bg-ink text-white lg:hidden" role="dialog" aria-modal="true" aria-label="Menu">
        <div class="flex h-full flex-col overflow-y-auto">
            <div class="flex h-[4.5rem] shrink-0 items-center justify-between px-5">
                <x-logo light />
                <button type="button" class="grid size-10 place-items-center rounded-full bg-white/10" @click="menu = false" aria-label="Close menu"><x-icon name="x" class="size-5" /></button>
            </div>
            <nav class="flex-1 px-5 pt-4 pb-10" aria-label="Mobile">
                <a href="{{ route('products') }}" class="block py-3 font-display text-2xl font-semibold">All insurance</a>
                <div class="mt-2 grid grid-cols-2 gap-x-4">
                    @foreach ($groups as $group)
                        @foreach ($group['items'] as $slug => $item)
                            <a href="{{ route('products.show', $slug) }}" class="flex items-center gap-2 py-2 text-sm text-white/80"><x-icon :name="$item['icon']" class="size-4 text-gold-300" /> {{ $item['name'] }}</a>
                        @endforeach
                    @endforeach
                </div>
                <div class="my-5 h-px bg-white/10"></div>
                @foreach ($links as [$route, $label])
                    <a href="{{ route($route) }}" class="block py-3 font-display text-2xl font-semibold">{{ $label }}</a>
                @endforeach
                <div class="mt-6 flex flex-col gap-3">
                    <a href="{{ route('quote') }}" class="btn btn-gold">Get a quote</a>
                    <a href="{{ $whatsapp }}" class="btn btn-whatsapp" target="_blank" rel="noopener"><x-icon name="message-circle" class="size-4" /> WhatsApp {{ $site['phone'] }}</a>
                </div>
            </nav>
        </div>
    </div>

    <main id="main" class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-ink text-white">
        <div class="h-px gilt opacity-70"></div>
        <div class="wrap grid gap-12 py-16 lg:grid-cols-[1.3fr_1fr_1fr_1fr]">
            <div>
                <x-logo light />
                <p class="mt-5 max-w-sm text-sm leading-relaxed text-white/60">{{ $site['intro'] }}</p>
                <div class="mt-6 space-y-2 text-sm">
                    <a href="tel:{{ $site['phone_href'] }}" class="flex items-center gap-2.5 text-white/80 hover:text-white"><x-icon name="phone" class="size-4 text-gold-300" /> {{ $site['phone'] }}</a>
                    <a href="mailto:{{ $site['email'] }}" class="flex items-center gap-2.5 text-white/80 hover:text-white"><x-icon name="mail" class="size-4 text-gold-300" /> {{ $site['email'] }}</a>
                    <a href="{{ $site['links']['instagram'] }}" target="_blank" rel="noopener" class="flex items-center gap-2.5 text-white/80 hover:text-white"><x-icon name="instagram" class="size-4 text-gold-300" /> {{ $site['social']['instagram_handle'] }}</a>
                    <p class="flex items-center gap-2.5 text-white/60"><x-icon name="map-pin" class="size-4 text-gold-300" /> {{ $site['service_area'] }}</p>
                    <p class="flex items-center gap-2.5 text-white/60"><x-icon name="clock" class="size-4 text-gold-300" /> {{ $site['hours'] }}</p>
                </div>
            </div>
            <div>
                <p class="text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Protect</p>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    @foreach ($groups['protect']['items'] as $slug => $item)
                        <li><a href="{{ route('products.show', $slug) }}" class="hover:text-white">{{ $item['name'] }}</a></li>
                    @endforeach
                </ul>
                <p class="mt-8 text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Grow</p>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    @foreach ($groups['grow']['items'] as $slug => $item)
                        <li><a href="{{ route('products.show', $slug) }}" class="hover:text-white">{{ $item['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Business &amp; lifestyle</p>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    @foreach ($groups['business']['items'] as $slug => $item)
                        <li><a href="{{ route('products.show', $slug) }}" class="hover:text-white">{{ $item['name'] }}</a></li>
                    @endforeach
                </ul>
                <p class="mt-8 text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Calculators</p>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    @foreach ($calculators as $slug => $calc)
                        <li><a href="{{ route('calculators.show', $slug) }}" class="hover:text-white">{{ $calc['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Rachel</p>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    <li><a href="{{ route('about') }}" class="hover:text-white">About Rachel Agostini</a></li>
                    <li><a href="{{ route('quote') }}" class="hover:text-white">Get a quote</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white">Questions answered</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-white">Privacy</a></li>
                </ul>
                <p class="mt-8 text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Guardian Group</p>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    <li><a href="{{ $site['links']['guardian_claim'] }}" target="_blank" rel="noopener" class="hover:text-white">Submit a claim</a></li>
                    <li><a href="{{ $site['links']['guardian_payment'] }}" target="_blank" rel="noopener" class="hover:text-white">Make a payment</a></li>
                    <li><a href="{{ $site['links']['guardian'] }}" target="_blank" rel="noopener" class="hover:text-white">myguardiangroup.com</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="wrap flex flex-col gap-3 py-6 text-xs text-white/45 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ date('Y') }} Rachel Agostini. Guardian Life of the Caribbean Limited sales representative, Trinidad and Tobago.</p>
                <p class="max-w-xl sm:text-right">This is Rachel Agostini's personal practice website, not the official site of Guardian Group. Guardian, Guardian Life, Guardian General and product names are trademarks of their owners. Calculators are estimates, not quotations.</p>
            </div>
        </div>
    </footer>
</body>
</html>
