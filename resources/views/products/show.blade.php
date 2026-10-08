<x-layout :title="$item['seo']['title']" :description="$item['seo']['description']" :schema="$schema">
    <section class="relative overflow-hidden bg-ink text-white">
        <div class="absolute inset-0 grid-ink opacity-50"></div>
        <div class="absolute inset-0 glow-brand"></div>
        <div class="wrap relative grid gap-10 py-14 sm:py-20 lg:grid-cols-[1.2fr_0.8fr] lg:items-end">
            <div>
                <nav aria-label="Breadcrumb" class="mb-6 text-xs font-semibold text-white/50">
                    <ol class="flex flex-wrap items-center gap-2">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                        <li aria-hidden="true">/</li>
                        <li><a href="{{ route('products') }}" class="hover:text-white">Insurance</a></li>
                        <li aria-hidden="true">/</li>
                        <li><span class="text-white/80">{{ $item['name'] }}</span></li>
                    </ol>
                </nav>
                <p class="eyebrow eyebrow-light">{{ $item['company'] }} &middot; {{ $item['eyebrow'] }}</p>
                <h1 class="mt-3 h-display">{{ $item['name'] }} in Trinidad &amp; Tobago, arranged by Rachel Agostini.</h1>
                <p class="mt-5 max-w-2xl text-lg text-white/70 sm:text-xl">{{ $item['summary'] }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#quote" class="btn btn-gold">Get a {{ strtolower($item['name']) }} quote</a>
                    @if ($calculator)
                        <a href="{{ route('calculators.show', $item['calculator']) }}" class="btn btn-onDark"><x-icon name="calculator" class="size-4" /> {{ $calculator['name'] }}</a>
                    @endif
                </div>
            </div>
            <div class="rounded-3xl bg-white/[0.06] p-6 ring-1 ring-white/10 backdrop-blur">
                <p class="text-[11px] font-bold tracking-[0.16em] text-gold-300 uppercase">Good fit for</p>
                <p class="mt-2 font-display text-xl font-semibold">{{ $item['fit'] }}</p>
                <ul class="mt-5 space-y-2.5 text-sm text-white/80">
                    @foreach ($item['benefits'] as $benefit)
                        <li class="flex gap-2.5"><x-icon name="circle-check" class="mt-0.5 size-4 shrink-0 text-gold-300" /> {{ $benefit }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="wrap grid gap-12 lg:grid-cols-[1.2fr_0.8fr]">
            <div>
                <div class="prose-site" data-reveal>
                    @foreach ($item['intro'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
                <h2 class="mt-12 h-section" data-reveal>Plans Rachel can quote</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @foreach ($item['plans'] as $plan)
                        <div class="rounded-3xl bg-white p-6 shadow-card ring-1 ring-line/70" data-reveal style="--reveal-delay: {{ $loop->index * 70 }}ms">
                            <span class="icon-tile size-10 rounded-xl"><x-icon :name="$item['icon']" class="size-5" /></span>
                            <h3 class="mt-4 h-card">{{ $plan['name'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">{{ $plan['blurb'] }}</p>
                        </div>
                    @endforeach
                </div>
                @if ($calculator)
                    <div class="mt-10 flex flex-col gap-6 rounded-3xl bg-ink p-8 text-white sm:flex-row sm:items-center sm:justify-between" data-reveal>
                        <div>
                            <p class="eyebrow eyebrow-light">Calculator</p>
                            <h3 class="mt-2 font-display text-2xl font-semibold">{{ $calculator['short'] }}</h3>
                            <p class="mt-2 text-sm text-white/70">{{ $calculator['summary'] }}</p>
                        </div>
                        <a href="{{ route('calculators.show', $item['calculator']) }}" class="btn btn-gold shrink-0">Open calculator <x-icon name="arrow-right" class="size-4" /></a>
                    </div>
                @endif
            </div>
            <aside class="space-y-5 lg:sticky lg:top-28 lg:self-start">
                <div class="card" id="quote" data-reveal>
                    <h2 class="h-card">Quote for {{ $item['name'] }}</h2>
                    <p class="mt-1 text-sm text-muted">Real Guardian premiums within one working day.</p>
                    <div class="mt-5">
                        <x-quote-form :products="collect(config('products.items'))->map(fn ($i) => $i['name'])->all()" :preselected="$slug" compact />
                    </div>
                </div>
                <div class="card flex items-center gap-4" data-reveal>
                    <img src="{{ asset('images/rachel-agostini-portrait.webp') }}" alt="Rachel Agostini" class="size-16 rounded-full object-cover ring-2 ring-gold-400" width="64" height="64" loading="lazy">
                    <div class="min-w-0">
                        <p class="font-bold">Rachel Agostini</p>
                        <p class="text-xs text-muted">{{ config('site.role') }}</p>
                        <a href="{{ \App\Support\Content::whatsapp('Hi Rachel, I am interested in '.$item['name'].'.') }}" target="_blank" rel="noopener" class="link-arrow mt-1 !text-emerald-700">WhatsApp Rachel <x-icon name="arrow-up-right" class="size-3.5" /></a>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section class="section bg-paper-deep/60">
        <div class="wrap">
            <div class="flex items-end justify-between gap-6" data-reveal>
                <h2 class="h-section">Often paired with</h2>
                <a href="{{ route('products') }}" class="link-arrow shrink-0">All products <x-icon name="arrow-right" class="size-4" /></a>
            </div>
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($related as $relatedSlug => $relatedItem)
                    <x-product-card :slug="$relatedSlug" :item="$relatedItem" compact data-reveal style="--reveal-delay: {{ $loop->index * 70 }}ms" />
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-band :product="$slug" :title="'Questions about '.strtolower($item['name']).'?'" />
</x-layout>
