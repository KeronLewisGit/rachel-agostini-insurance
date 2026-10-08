@php($site = config('site'))
<x-layout :schema="$schema">
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-ink text-white">
        <div class="absolute inset-0 grid-ink opacity-50"></div>
        <div class="absolute inset-0 glow-brand"></div>
        <div class="absolute inset-0 glow-gold"></div>
        <div class="wrap relative grid gap-12 py-16 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:py-24">
            <div>
                <p class="eyebrow eyebrow-light">Guardian Life of the Caribbean &middot; Trinidad &amp; Tobago</p>
                <h1 class="mt-5 h-display">Rachel Agostini. <span class="text-gold-300">Protection planned</span> around your life.</h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-white/75 sm:text-xl">Life, critical illness, health, pension and investment plans from Guardian Life of the Caribbean, arranged personally by a Central Bank-registered sales representative and TTAIFA national awardee. One conversation, a written plan, and premiums you can actually see.</p>
                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ route('quote') }}" class="btn btn-gold !px-6 !py-3.5 text-base">Get a free quote <x-icon name="arrow-right" class="size-4" /></a>
                    <a href="{{ route('calculators') }}" class="btn btn-onDark !px-6 !py-3.5 text-base"><x-icon name="calculator" class="size-4" /> Run the numbers</a>
                </div>
                <dl class="mt-10 grid max-w-xl grid-cols-3 gap-6 border-t border-white/10 pt-8">
                    <div>
                        <dt class="text-[11px] font-bold tracking-[0.16em] text-gold-300 uppercase">Registered</dt>
                        <dd class="mt-1 text-sm font-semibold">Central Bank of T&amp;T sales register</dd>
                    </div>
                    <div>
                        <dt class="text-[11px] font-bold tracking-[0.16em] text-gold-300 uppercase">Recognised</dt>
                        <dd class="mt-1 text-sm font-semibold">TTAIFA National Awardee 2024</dd>
                    </div>
                    <div>
                        <dt class="text-[11px] font-bold tracking-[0.16em] text-gold-300 uppercase">Backed by</dt>
                        <dd class="mt-1 text-sm font-semibold">Guardian Group, since 1847</dd>
                    </div>
                </dl>
            </div>
            <div class="relative mx-auto w-full max-w-md lg:max-w-none">
                <div class="relative aspect-[4/5] overflow-hidden rounded-[2.5rem]">
                    {{-- Soft glow behind the cut-out portrait so it sits in the hero rather than on a card. --}}
                    <div class="absolute top-[12%] left-1/2 h-[70%] w-[80%] -translate-x-1/2 rounded-full bg-accent-600/35 blur-3xl" aria-hidden="true"></div>
                    <div class="absolute bottom-0 left-1/2 h-[45%] w-[90%] -translate-x-1/2 rounded-full bg-brand-600/40 blur-3xl" aria-hidden="true"></div>
                    <img src="{{ asset('images/rachel-agostini-cutout.webp') }}" alt="Rachel Agostini, Guardian Life of the Caribbean sales representative in Trinidad and Tobago" class="relative h-full w-full object-cover object-top" width="500" height="815" fetchpriority="high">
                    <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-ink/70 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5 flex items-end justify-between gap-3">
                        <div>
                            <p class="font-display text-2xl font-semibold">Rachel Agostini</p>
                            <p class="text-sm text-white/70">Sales Representative, Guardian Life of the Caribbean</p>
                        </div>
                        <a href="{{ $site['links']['instagram'] }}" target="_blank" rel="noopener" class="grid size-11 shrink-0 place-items-center rounded-full bg-white/15 ring-1 ring-white/20 backdrop-blur transition hover:bg-white/25" aria-label="Rachel on Instagram"><x-icon name="instagram" class="size-5" /></a>
                    </div>
                </div>
                <div class="absolute -left-4 top-10 hidden animate-float rounded-2xl bg-white p-4 text-ink shadow-lift sm:block lg:-left-10">
                    <div class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-xl bg-gold-100 text-gold-700"><x-icon name="award" class="size-5" /></span>
                        <div>
                            <p class="text-xs font-bold tracking-wider text-muted uppercase">TTAIFA 2024</p>
                            <p class="text-sm font-bold">Ruby Production Award</p>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-3 bottom-24 hidden animate-float-slow rounded-2xl bg-white p-4 text-ink shadow-lift sm:block lg:-right-8">
                    <div class="flex items-center gap-3">
                        <span class="relative grid size-10 place-items-center rounded-xl bg-emerald-100 text-emerald-700">
                            <span class="absolute inset-0 animate-pulse-ring rounded-xl bg-emerald-300"></span>
                            <x-icon name="message-circle" class="relative size-5" />
                        </span>
                        <div>
                            <p class="text-xs font-bold tracking-wider text-muted uppercase">Replies</p>
                            <p class="text-sm font-bold">Within one working day</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Marquee --}}
        <div class="relative border-t border-white/10 bg-ink/60 py-3.5 backdrop-blur">
            <div class="flex overflow-hidden" aria-hidden="true">
                <div class="flex shrink-0 animate-marquee items-center gap-10 pr-10 text-xs font-bold tracking-[0.18em] text-white/60 uppercase">
                    @foreach (array_merge(array_values(config('products.items')), array_values(config('products.items'))) as $item)
                        <span class="flex items-center gap-3"><x-icon :name="$item['icon']" class="size-4 text-gold-300" /> {{ $item['name'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Products --}}
    <section class="section">
        <div class="wrap">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between" data-reveal>
                <div class="max-w-2xl">
                    <p class="eyebrow">What Rachel arranges</p>
                    <h2 class="mt-3 h-section">Twelve lines of cover. One advisor who knows your whole picture.</h2>
                    <p class="mt-4 lead">Guardian Life of the Caribbean for the people and income you protect, Guardian Asset Management for what you grow, and Guardian General covers for the business, the trip and the boat through the same Guardian Group relationship. Rachel does not write motor, cyber or home.</p>
                </div>
                <a href="{{ route('products') }}" class="link-arrow shrink-0">See all twelve <x-icon name="arrow-right" class="size-4" /></a>
            </div>
            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured as $slug => $item)
                    <x-product-card :slug="$slug" :item="$item" data-reveal style="--reveal-delay: {{ $loop->index * 70 }}ms" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Starter --}}
    <section class="section bg-paper-deep/60">
        <div class="wrap" x-data="starter({{ Js::from($paths) }})">
            <div class="max-w-2xl" data-reveal>
                <p class="eyebrow">Not sure where to start?</p>
                <h2 class="mt-3 h-section">Tell Rachel where you are. She will tell you what matters first.</h2>
            </div>
            <div class="mt-8 flex flex-wrap gap-2" role="tablist" aria-label="Your situation">
                @foreach ($paths as $key => $path)
                    <button type="button" role="tab" @click="picked = '{{ $key }}'" :aria-selected="picked === '{{ $key }}'" :class="picked === '{{ $key }}' ? 'bg-ink text-white ring-ink' : 'bg-white text-ink ring-line hover:ring-ink/40'" class="inline-flex items-center gap-2 rounded-full px-4 py-2.5 text-sm font-semibold ring-1 transition">
                        <x-icon :name="$path['icon']" class="size-4" /> {{ $path['label'] }}
                    </button>
                @endforeach
            </div>
            <div class="mt-8 grid gap-6 rounded-[2rem] bg-white p-6 shadow-card ring-1 ring-line/70 sm:p-10 lg:grid-cols-[1fr_1fr]" role="tabpanel">
                <div>
                    <h3 class="font-display text-2xl font-semibold sm:text-3xl" x-text="current.title"></h3>
                    <p class="mt-4 leading-relaxed text-muted" x-text="current.text"></p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('quote') }}" class="btn btn-primary">Ask Rachel about this</a>
                        <template x-if="current.calculator">
                            <a :href="'{{ url('/calculators') }}/' + current.calculator" class="btn btn-light"><x-icon name="calculator" class="size-4" /> Open the calculator</a>
                        </template>
                    </div>
                </div>
                <div class="grid gap-3">
                    <template x-for="slug in current.products" :key="slug">
                        <a :href="'{{ url('/insurance') }}/' + slug" class="group flex items-center justify-between rounded-2xl bg-paper px-5 py-4 transition hover:bg-brand-50">
                            <span>
                                <span class="block text-[11px] font-bold tracking-[0.16em] text-brand-700 uppercase" x-text="({{ json_encode(collect(config('products.items'))->map(fn ($i) => $i['company'])) }})[slug]"></span>
                                <span class="block font-semibold" x-text="({{ json_encode(collect(config('products.items'))->map(fn ($i) => $i['name'])) }})[slug]"></span>
                            </span>
                            <x-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" />
                        </a>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- Calculators --}}
    <section class="relative overflow-hidden bg-ink text-white">
        <div class="absolute inset-0 grid-ink opacity-50"></div>
        <div class="absolute inset-0 glow-brand"></div>
        <div class="wrap relative section">
            <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                <div data-reveal>
                    <p class="eyebrow eyebrow-light">Insurance calculators</p>
                    <h2 class="mt-3 h-section">Run the numbers before we talk.</h2>
                    <p class="mt-4 text-lg text-white/70">Four calculators built for Trinidad and Tobago incomes, tax rules and tuition costs. Move the sliders, see the figure, and send the estimate straight to Rachel so the first call starts with your numbers, not a blank page.</p>
                    <a href="{{ route('calculators') }}" class="btn btn-gold mt-7">All calculators <x-icon name="arrow-right" class="size-4" /></a>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($calculators as $slug => $calc)
                        <a href="{{ route('calculators.show', $slug) }}" class="group rounded-3xl bg-white/[0.06] p-6 ring-1 ring-white/10 backdrop-blur transition hover:bg-white/10 hover:ring-gold-300/50" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                            <span class="grid size-11 place-items-center rounded-2xl bg-gold-400 text-ink"><x-icon :name="$calc['icon']" class="size-5" /></span>
                            <span class="mt-5 block font-display text-xl font-semibold">{{ $calc['name'] }}</span>
                            <span class="mt-1.5 block text-sm text-white/65">{{ $calc['short'] }}</span>
                            <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-bold text-gold-300 transition group-hover:gap-2.5">Open <x-icon name="arrow-right" class="size-4" /></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- About --}}
    <section class="section">
        <div class="wrap grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:items-center">
            <div class="relative mx-auto w-full max-w-sm" data-reveal>
                <div class="aspect-[4/5] overflow-hidden rounded-[2rem] shadow-lift ring-1 ring-line">
                    <img src="{{ asset('images/rachel-agostini.webp') }}" alt="Rachel Agostini, insurance advisor, Trinidad and Tobago" class="h-full w-full object-cover object-top" width="500" height="815" loading="lazy">
                </div>
                <figure class="absolute -bottom-6 -right-4 max-w-[16rem] rounded-2xl bg-ink p-5 text-white shadow-lift sm:-right-10">
                    <x-icon name="quote" class="size-5 text-gold-300" />
                    <blockquote class="mt-2 text-sm leading-relaxed">Life insurance takes care of the loved ones we leave behind. Critical illness is a living benefit that protects you.</blockquote>
                    <figcaption class="mt-3 text-xs font-semibold text-white/60">Rachel, on Instagram</figcaption>
                </figure>
            </div>
            <div data-reveal style="--reveal-delay: 100ms">
                <p class="eyebrow">About Rachel</p>
                <h2 class="mt-3 h-section">An advisor her clients nominate for awards.</h2>
                <p class="mt-5 lead">Rachel Agostini is a sales representative with Guardian Life of the Caribbean Limited, the flagship life, health and pensions company of Guardian Group, the Caribbean's largest indigenous insurer. In 2024 the Trinidad and Tobago Association of Insurance and Financial Advisors named her a National Awardee with its Ruby Production Award. Her thanks went to her clients, "who made this possible".</p>
                <ul class="mt-8 grid gap-4 sm:grid-cols-2">
                    @foreach ($site['credentials'] as $credential)
                        <li class="flex gap-4 rounded-2xl bg-white p-4 ring-1 ring-line/70">
                            <span class="icon-tile size-10 rounded-xl"><x-icon :name="$credential['icon']" class="size-5" /></span>
                            <div>
                                <p class="font-bold">{{ $credential['title'] }}</p>
                                <p class="mt-1 text-sm leading-relaxed text-muted">{{ $credential['detail'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('about') }}" class="link-arrow mt-8">More about Rachel <x-icon name="arrow-right" class="size-4" /></a>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="border-y border-line bg-white">
        <div class="wrap grid grid-cols-2 gap-8 py-12 lg:grid-cols-4">
            @foreach ($site['stats'] as $stat)
                <div data-reveal style="--reveal-delay: {{ $loop->index * 60 }}ms" x-data="countUp({{ (int) $stat['value'] }})" x-init="start()">
                    <p class="stat-num text-brand-700" x-text="value.toLocaleString()">{{ $stat['value'] }}</p>
                    <p class="mt-2 text-sm font-semibold text-muted">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Process --}}
    <section class="section">
        <div class="wrap">
            <div class="max-w-2xl" data-reveal>
                <p class="eyebrow">How it works</p>
                <h2 class="mt-3 h-section">No jargon, no pressure, no surprises on the premium.</h2>
            </div>
            <ol class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($site['process'] as $step)
                    <li class="relative rounded-3xl bg-white p-6 shadow-card ring-1 ring-line/70" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        <span class="font-display text-5xl font-semibold text-gold-400">0{{ $loop->iteration }}</span>
                        <h3 class="mt-4 h-card">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $step['body'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="section bg-paper-deep/60">
        <div class="wrap grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
            <div data-reveal>
                <p class="eyebrow">Questions</p>
                <h2 class="mt-3 h-section">The things people ask Rachel first.</h2>
                <p class="mt-4 lead">Straight answers on licensing, cost, tax and what happens after you get in touch.</p>
                <a href="{{ route('faq') }}" class="link-arrow mt-6">All questions <x-icon name="arrow-right" class="size-4" /></a>
            </div>
            <x-faq-list :faqs="$faqs" data-reveal />
        </div>
    </section>

    <x-cta-band />
</x-layout>
