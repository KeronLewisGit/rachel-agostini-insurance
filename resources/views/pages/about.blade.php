@php($site = config('site'))
<x-layout title="About Rachel Agostini" description="Rachel Agostini is a Guardian Life of the Caribbean sales representative in Trinidad and Tobago, Central Bank registered and a TTAIFA National Awardee 2024. Meet her and learn how she works." :schema="$schema">
    <x-page-hero eyebrow="About Rachel" title="Rachel Agostini, Guardian Life of the Caribbean representative in Trinidad &amp; Tobago." text="An award-winning advisor who treats insurance as a plan for living, not just a payout." :crumbs="['About Rachel' => null]" />

    <section class="section">
        <div class="wrap grid gap-12 lg:grid-cols-[0.75fr_1.25fr]">
            <div class="space-y-6">
                <div class="overflow-hidden rounded-[2rem] shadow-lift ring-1 ring-line" data-reveal>
                    <img src="{{ asset('images/rachel-agostini.webp') }}" alt="Rachel Agostini, Guardian Life of the Caribbean sales representative" class="w-full object-cover" width="500" height="815">
                </div>
                <div class="card" data-reveal>
                    <p class="text-[11px] font-bold tracking-[0.16em] text-brand-700 uppercase">Get in touch</p>
                    <div class="mt-4 space-y-3 text-sm">
                        <a href="tel:{{ $site['phone_href'] }}" class="flex items-center gap-3 font-semibold hover:text-brand-700"><x-icon name="phone" class="size-4 text-gold-600" /> {{ $site['phone'] }}</a>
                        <a href="mailto:{{ $site['email'] }}" class="flex items-center gap-3 font-semibold hover:text-brand-700"><x-icon name="mail" class="size-4 shrink-0 text-gold-600" /> <span class="break-all">{{ $site['email'] }}</span></a>
                        <a href="{{ $site['links']['instagram'] }}" target="_blank" rel="noopener" class="flex items-center gap-3 font-semibold hover:text-brand-700"><x-icon name="instagram" class="size-4 text-gold-600" /> {{ $site['social']['instagram_handle'] }}</a>
                    </div>
                    <a href="{{ \App\Support\Content::whatsapp('Hi Rachel, I read your About page and would like to talk.') }}" target="_blank" rel="noopener" class="btn btn-whatsapp mt-5 w-full"><x-icon name="message-circle" class="size-4" /> WhatsApp Rachel</a>
                </div>
            </div>
            <div class="prose-site" data-reveal style="--reveal-delay: 100ms">
                <p class="eyebrow">Her story</p>
                <h2 class="mt-3 h-section !text-ink">Insurance that pays while you are living, not only after.</h2>
                <p>Rachel Agostini is a sales representative with Guardian Life of the Caribbean Limited, the flagship life, health and pensions company of Guardian Group. She is listed on the Central Bank of Trinidad and Tobago's register of insurance sales representatives.</p>
                <p>Her practice is built on a simple idea she has repeated to clients since 2022: life insurance takes care of the loved ones we leave behind, while critical illness cover is a living benefit that protects you in the event of an unforeseen illness. Most households have neither sized properly. Rachel's job is to fix that without selling anyone more than they need.</p>
                <p>In 2024 the Trinidad and Tobago Association of Insurance and Financial Advisors (TTAIFA) recognised her with its Ruby Production Award and named her a National Awardee for outstanding production in 2023. Her response was characteristic: "Thank you to my clients that made this possible."</p>
                <h3 class="font-display text-2xl font-semibold !text-ink">What she arranges</h3>
                <p>Through Guardian Life: whole life, term and Life Evolution policies, the Phoenix Plan for critical illness, LifeCare and Global Care health plans, Lifestyle Pensions and registered annuities, education savings, personal accident and employee benefits. Through Guardian Asset Management: mutual funds and private wealth services. And because Guardian Life sits inside Guardian Group, she can also arrange Guardian General travel, business, marine and pet covers. She does not write motor, cyber or home insurance.</p>
                <h3 class="font-display text-2xl font-semibold !text-ink">How she works</h3>
                <ol class="!mt-4 space-y-4">
                    @foreach ($site['process'] as $step)
                        <li class="flex gap-4">
                            <span class="grid size-8 shrink-0 place-items-center rounded-full bg-brand-600 text-sm font-bold text-white">{{ $loop->iteration }}</span>
                            <span><strong class="font-bold text-ink">{{ $step['title'] }}.</strong> {{ $step['body'] }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    <section class="section bg-paper-deep/60">
        <div class="wrap">
            <div class="max-w-2xl" data-reveal>
                <p class="eyebrow">Credentials</p>
                <h2 class="mt-3 h-section">Why clients trust the name on the policy.</h2>
            </div>
            <div class="mt-10 grid gap-5 md:grid-cols-2">
                @foreach ($site['credentials'] as $credential)
                    <div class="card flex gap-5" data-reveal style="--reveal-delay: {{ $loop->index * 70 }}ms">
                        <span class="icon-tile"><x-icon :name="$credential['icon']" class="size-6" /></span>
                        <div>
                            <h3 class="h-card">{{ $credential['title'] }}</h3>
                            <p class="mt-2 leading-relaxed text-muted">{{ $credential['detail'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="wrap grid gap-10 lg:grid-cols-[1fr_1fr] lg:items-center">
            <div data-reveal>
                <p class="eyebrow">Guardian Group</p>
                <h2 class="mt-3 h-section">A 179-year-old Caribbean institution behind every policy.</h2>
                <p class="mt-4 lead">Guardian Holdings Limited traces its roots to 1847, when Standard Life of Edinburgh opened a branch in Trinidad. Today the group is headquartered in Westmoorings and serves 21 countries across the English and Dutch Caribbean through Guardian Life of the Caribbean, Guardian General Insurance and Guardian Asset Management.</p>
            </div>
            <ol class="relative space-y-6 border-l-2 border-brand-100 pl-6" data-reveal style="--reveal-delay: 100ms">
                @foreach ([['1847', 'Standard Life of Edinburgh opens a branch office in Trinidad.'], ['1980', 'Guardian Life of The Caribbean is incorporated.'], ['2007', 'NEMWIL and Guardian General Insurance Limited amalgamate.'], ['2013', 'The companies unite under one brand: Guardian Group.'], ['Today', '21 countries, one promise: "life is easier when we take time to make each other stronger."']] as [$year, $event])
                    <li class="relative">
                        <span class="absolute -left-[2.05rem] top-1 size-4 rounded-full border-4 border-white bg-brand-600 shadow"></span>
                        <p class="font-display text-xl font-semibold text-brand-700">{{ $year }}</p>
                        <p class="text-muted">{{ $event }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <x-cta-band title="Let's talk about your plan." />
</x-layout>
