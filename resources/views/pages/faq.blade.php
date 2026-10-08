<x-layout title="Insurance FAQ" description="Answers from Rachel Agostini, Guardian Life of the Caribbean sales representative in Trinidad and Tobago: licensing, costs, tax deductions for annuities, critical illness payouts and how quickly you will hear back." :schema="$schema">
    <x-page-hero eyebrow="Questions answered" title="Insurance questions, answered plainly." text="If yours is not here, WhatsApp Rachel. She will answer it and probably add it to the list." :crumbs="['FAQ' => null]" />
    <section class="section">
        <div class="wrap grid gap-10 lg:grid-cols-[1fr_0.5fr]">
            <x-faq-list :faqs="$faqs" data-reveal />
            <aside class="space-y-5">
                <div class="card" data-reveal>
                    <h2 class="h-card">Still unsure?</h2>
                    <p class="mt-2 text-sm text-muted">A twenty-minute call usually answers everything. Free, no obligation.</p>
                    <a href="{{ route('quote') }}" class="btn btn-primary mt-5 w-full">Get a quote</a>
                    <a href="{{ \App\Support\Content::whatsapp('Hi Rachel, I have a question about insurance.') }}" target="_blank" rel="noopener" class="btn btn-whatsapp mt-2 w-full"><x-icon name="message-circle" class="size-4" /> WhatsApp</a>
                </div>
                <div class="card" data-reveal>
                    <h2 class="h-card">Try a calculator</h2>
                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach (config('calculators.items') as $slug => $calc)
                            <li><a href="{{ route('calculators.show', $slug) }}" class="link-arrow">{{ $calc['name'] }} <x-icon name="arrow-right" class="size-3.5" /></a></li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </section>
    <x-cta-band />
</x-layout>
