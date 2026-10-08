@props(['title' => 'Ready when you are.', 'text' => 'Twenty minutes with Rachel is enough to know where you stand. Free, no obligation, by WhatsApp, phone or in person.', 'product' => null])
<section class="relative overflow-hidden bg-ink text-white">
    <div class="absolute inset-0 grid-ink opacity-60"></div>
    <div class="absolute inset-0 glow-brand"></div>
    <div class="absolute -right-24 -bottom-32 size-96 rounded-full bg-gold-400/20 blur-3xl"></div>
    <div class="wrap relative grid gap-10 py-16 sm:py-20 lg:grid-cols-[1fr_1.1fr] lg:items-center">
        <div data-reveal>
            <p class="eyebrow eyebrow-light">Talk to Rachel</p>
            <h2 class="mt-3 h-section">{{ $title }}</h2>
            <p class="mt-4 max-w-md text-lg text-white/70">{{ $text }}</p>
            <div class="mt-7 flex flex-wrap gap-3">
                <a href="{{ \App\Support\Content::whatsapp('Hi Rachel, I found your website and would like to talk about insurance.') }}" target="_blank" rel="noopener" class="btn btn-whatsapp"><x-icon name="message-circle" class="size-4" /> WhatsApp Rachel</a>
                <a href="tel:{{ config('site.phone_href') }}" class="btn btn-onDark"><x-icon name="phone" class="size-4" /> {{ config('site.phone') }}</a>
            </div>
            <p class="mt-6 text-sm text-white/50">{{ config('site.hours') }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 text-ink shadow-lift sm:p-8" data-reveal style="--reveal-delay: 120ms">
            <h3 class="h-card">Or ask for a call back</h3>
            <p class="mt-1 text-sm text-muted">Pick a time and Rachel will phone you.</p>
            <x-callback-form :product="$product" class="mt-5" />
        </div>
    </div>
</section>
