<x-layout title="Free Insurance Calculators" description="Free insurance calculators for Trinidad and Tobago by Rachel Agostini: life cover, critical illness, retirement and annuity tax savings, and education costs. See a figure in a minute and send it to Rachel for a Guardian quote." :schema="$schema">
    <x-page-hero eyebrow="Insurance calculators" title="See the number before you see an advisor." text="Built for Trinidad and Tobago incomes, tax rules and tuition costs. Move the sliders, read the result, send it to Rachel if you want it turned into real premiums." :crumbs="['Calculators' => null]" />
    <section class="section">
        <div class="wrap grid gap-5 md:grid-cols-2">
            @foreach ($calculators as $slug => $calc)
                <a href="{{ route('calculators.show', $slug) }}" class="group relative overflow-hidden rounded-[2rem] bg-white p-8 shadow-card ring-1 ring-line/70 transition duration-300 hover:-translate-y-1 hover:shadow-lift hover:ring-brand-200" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                    <div class="absolute -right-10 -top-10 size-40 rounded-full bg-brand-50 transition group-hover:bg-gold-100"></div>
                    <span class="relative icon-tile bg-ink text-white group-hover:bg-brand-600"><x-icon :name="$calc['icon']" class="size-6" /></span>
                    <h2 class="relative mt-6 font-display text-2xl font-semibold">{{ $calc['name'] }}</h2>
                    <p class="relative mt-1 font-semibold text-brand-700">{{ $calc['short'] }}</p>
                    <p class="relative mt-3 leading-relaxed text-muted">{{ $calc['summary'] }}</p>
                    <span class="relative mt-6 inline-flex items-center gap-1.5 text-sm font-bold transition group-hover:gap-2.5 group-hover:text-brand-700">Open calculator <x-icon name="arrow-right" class="size-4" /></span>
                </a>
            @endforeach
        </div>
        <div class="wrap mt-10">
            <div class="rounded-3xl bg-paper-deep/70 p-6 text-sm text-muted ring-1 ring-line/70 sm:p-8" data-reveal>
                <p><strong class="font-bold text-ink">How to read the results.</strong> These calculators give you a cover amount or savings target to discuss, using assumptions shown on each page (3% inflation, 4% to 8% growth, a 25% income tax rate and the current annuity deduction limit). They are not quotations, and the illustrative premium bands are not Guardian's rates. Rachel will replace every estimate with a real figure.</p>
            </div>
        </div>
    </section>
    <x-cta-band title="Want the real premium?" text="Send Rachel the estimate from any calculator, or ask for a call back here." />
</x-layout>
