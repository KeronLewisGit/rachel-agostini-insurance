<x-layout title="Insurance Products" description="Every Guardian Group product Rachel Agostini arranges in Trinidad and Tobago: life, critical illness, health, personal accident, pensions, education, investments, employee benefits, business, travel, marine and pet insurance." :schema="$schema">
    <x-page-hero eyebrow="Insurance products" title="Twelve ways to protect what you have and grow what you will need." text="Guardian Life of the Caribbean for people and income, Guardian Asset Management for growth, and Guardian General covers for business and lifestyle, all through one Guardian Life representative." :crumbs="['Insurance products' => null]">
        <div class="mt-8 flex flex-wrap gap-2">
            @foreach ($groups as $key => $group)
                <a href="#{{ $key }}" class="chip !bg-white/10 !text-white !ring-white/20 hover:!bg-white/20">{{ $group['name'] }} <span class="text-white/50">{{ count($group['items']) }}</span></a>
            @endforeach
        </div>
    </x-page-hero>

    @foreach ($groups as $key => $group)
        <section id="{{ $key }}" class="section {{ $loop->even ? 'bg-paper-deep/60' : '' }}">
            <div class="wrap">
                <div class="max-w-2xl" data-reveal>
                    <p class="eyebrow">{{ $group['name'] }}</p>
                    <h2 class="mt-3 h-section">{{ $group['blurb'] }}</h2>
                </div>
                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($group['items'] as $slug => $item)
                        <x-product-card :slug="$slug" :item="$item" data-reveal style="--reveal-delay: {{ $loop->index * 70 }}ms" />
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach

    <section class="section">
        <div class="wrap">
            <div class="rounded-3xl bg-white p-8 shadow-card ring-1 ring-line/70 lg:flex lg:items-center lg:justify-between lg:gap-10" data-reveal>
                <div class="max-w-2xl">
                    <p class="eyebrow">For the record</p>
                    <h2 class="mt-3 font-display text-2xl font-semibold">Rachel does not write {{ implode(', ', array_slice($excluded, 0, -1)) }} or {{ end($excluded) }} insurance.</h2>
                    <p class="mt-3 text-muted">Those are available from Guardian General directly. Keeping them off this list means every conversation with Rachel is about the covers she specialises in.</p>
                </div>
                <a href="{{ config('site.links.guardian') }}" target="_blank" rel="noopener" class="btn btn-light mt-6 shrink-0 lg:mt-0">Guardian Group website <x-icon name="external-link" class="size-4" /></a>
            </div>
        </div>
    </section>

    <x-cta-band />
</x-layout>
