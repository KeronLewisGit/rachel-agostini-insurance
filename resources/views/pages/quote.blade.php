<x-layout title="Get a Free Insurance Quote" description="Request a free, no-obligation quote from Rachel Agostini for Guardian Life of the Caribbean plans and Guardian Group covers in Trinidad and Tobago. Real premiums within one working day." :schema="$schema">
    <x-page-hero eyebrow="Free quote" title="Real Guardian premiums, within one working day." text="Tell Rachel what you need and a little about yourself. She comes back with two or three priced options and a plain explanation of each." :crumbs="['Get a quote' => null]" />
    <section class="section">
        <div class="wrap grid gap-10 lg:grid-cols-[1.3fr_0.7fr]">
            <div class="card" data-reveal>
                <x-quote-form :products="$products" :preselected="$preselected" />
            </div>
            <aside class="space-y-5">
                <div class="card" data-reveal>
                    <p class="eyebrow">What happens next</p>
                    <ol class="mt-4 space-y-4 text-sm">
                        @foreach ([['Within an hour', 'You get an acknowledgement with a reference number.'], ['Within one working day', 'Rachel calls or WhatsApps to confirm a few details.'], ['Within two days', 'A written summary with real premiums arrives by WhatsApp or email.'], ['Whenever you are ready', 'Rachel handles the application and keeps you posted until the policy is issued.']] as [$when, $what])
                            <li class="flex gap-3">
                                <span class="grid size-7 shrink-0 place-items-center rounded-full bg-brand-600 text-xs font-bold text-white">{{ $loop->iteration }}</span>
                                <span><strong class="block font-bold">{{ $when }}</strong><span class="text-muted">{{ $what }}</span></span>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <div class="card bg-gold-50 ring-gold-200" data-reveal>
                    <h2 class="h-card">Prefer to see a number first?</h2>
                    <p class="mt-2 text-sm text-muted">The calculators give you a cover amount in a minute, and you can send the estimate to Rachel from there.</p>
                    <a href="{{ route('calculators') }}" class="btn btn-dark mt-4 w-full"><x-icon name="calculator" class="size-4" /> Open calculators</a>
                </div>
                <div class="card" data-reveal>
                    <h2 class="h-card">In a hurry?</h2>
                    <a href="{{ \App\Support\Content::whatsapp('Hi Rachel, I would like a quote.') }}" target="_blank" rel="noopener" class="btn btn-whatsapp mt-4 w-full"><x-icon name="message-circle" class="size-4" /> WhatsApp {{ config('site.phone') }}</a>
                </div>
            </aside>
        </div>
    </section>
</x-layout>
