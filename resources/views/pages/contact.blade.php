@php($site = config('site'))
<x-layout title="Contact Rachel Agostini" description="Contact Rachel Agostini, Guardian Life of the Caribbean sales representative in Trinidad and Tobago. Call or WhatsApp (868) 347-8006, email rachel.agostini@myguardiangroup.com, or send a message." :schema="$schema">
    <x-page-hero eyebrow="Contact" title="Talk to Rachel." text="WhatsApp is fastest. Email works. The form below reaches her too, with a reference number so nothing gets lost." :crumbs="['Contact' => null]" />
    <section class="section">
        <div class="wrap grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
            <div class="space-y-5">
                <div class="card" data-reveal>
                    <h2 class="h-card">Direct lines</h2>
                    <div class="mt-5 space-y-4">
                        <a href="{{ \App\Support\Content::whatsapp('Hi Rachel, I would like to talk about insurance.') }}" target="_blank" rel="noopener" class="flex items-center gap-4 rounded-2xl bg-emerald-50 p-4 ring-1 ring-emerald-200 transition hover:bg-emerald-100">
                            <span class="grid size-11 place-items-center rounded-xl bg-emerald-600 text-white"><x-icon name="message-circle" class="size-5" /></span>
                            <span><span class="block text-xs font-bold tracking-wider text-emerald-800 uppercase">WhatsApp</span><span class="block font-bold">{{ $site['phone'] }}</span></span>
                        </a>
                        <a href="tel:{{ $site['phone_href'] }}" class="flex items-center gap-4 rounded-2xl bg-paper p-4 ring-1 ring-line transition hover:bg-brand-50">
                            <span class="grid size-11 place-items-center rounded-xl bg-brand-600 text-white"><x-icon name="phone" class="size-5" /></span>
                            <span><span class="block text-xs font-bold tracking-wider text-muted uppercase">Call</span><span class="block font-bold">{{ $site['phone'] }}</span></span>
                        </a>
                        <a href="mailto:{{ $site['email'] }}" class="flex items-center gap-4 rounded-2xl bg-paper p-4 ring-1 ring-line transition hover:bg-brand-50">
                            <span class="grid size-11 place-items-center rounded-xl bg-ink text-white"><x-icon name="mail" class="size-5" /></span>
                            <span class="min-w-0"><span class="block text-xs font-bold tracking-wider text-muted uppercase">Email</span><span class="block truncate font-bold">{{ $site['email'] }}</span></span>
                        </a>
                        <a href="{{ $site['links']['instagram'] }}" target="_blank" rel="noopener" class="flex items-center gap-4 rounded-2xl bg-paper p-4 ring-1 ring-line transition hover:bg-brand-50">
                            <span class="grid size-11 place-items-center rounded-xl bg-gradient-to-br from-fuchsia-600 to-amber-400 text-white"><x-icon name="instagram" class="size-5" /></span>
                            <span><span class="block text-xs font-bold tracking-wider text-muted uppercase">Instagram</span><span class="block font-bold">{{ $site['social']['instagram_handle'] }}</span></span>
                        </a>
                    </div>
                </div>
                <div class="card" data-reveal>
                    <h2 class="h-card">Hours and where</h2>
                    <p class="mt-3 flex gap-3 text-sm text-muted"><x-icon name="clock" class="mt-0.5 size-4 shrink-0 text-gold-600" /> {{ $site['hours'] }}</p>
                    <p class="mt-3 flex gap-3 text-sm text-muted"><x-icon name="map-pin" class="mt-0.5 size-4 shrink-0 text-gold-600" /> {{ $site['service_area'] }}</p>
                </div>
                <div class="card bg-ink text-white" data-reveal>
                    <h2 class="h-card">Already a Guardian client?</h2>
                    <p class="mt-2 text-sm text-white/70">Claims and payments go straight to Guardian's secure portal. Rachel can still help you through it.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ $site['links']['guardian_claim'] }}" target="_blank" rel="noopener" class="btn btn-onDark !py-2 text-xs">Submit a claim</a>
                        <a href="{{ $site['links']['guardian_payment'] }}" target="_blank" rel="noopener" class="btn btn-onDark !py-2 text-xs">Make a payment</a>
                    </div>
                </div>
            </div>
            <div class="card" id="form-contact" data-reveal style="--reveal-delay: 100ms">
                <h2 class="h-card">Send a message</h2>
                <p class="mt-1 text-sm text-muted">Rachel replies within one working day.</p>
                <div class="mt-5">
                    <x-form-status type="contact" title="Message sent." message="Rachel will reply within one working day." />
                    <form method="POST" action="{{ route('leads.store', 'contact') }}" class="space-y-4">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2">
                            <x-field name="name" label="Your name" bag="contact" required autocomplete="name" />
                            <x-field name="email" label="Email" type="email" bag="contact" required autocomplete="email" />
                            <x-field name="phone" label="Phone or WhatsApp" type="tel" bag="contact" autocomplete="tel" />
                            <x-field name="product" label="About" type="select" bag="contact" :options="$products" placeholder="General question" />
                        </div>
                        <x-field name="message" label="Your message" type="textarea" bag="contact" required rows="6" />
                        <x-consent bag="contact" />
                        <button class="btn btn-primary">Send message <x-icon name="send" class="size-4" /></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layout>
