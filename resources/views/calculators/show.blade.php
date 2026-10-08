@php
    $growthOptions = ['conservative' => 'Conservative (4%)', 'balanced' => 'Balanced (6%)', 'growth' => 'Growth (8%)'];
    $money = fn ($n) => 'TT$'.number_format($n);
@endphp
<x-layout :title="$item['name']" :description="$item['description']" :schema="$schema">
    <x-page-hero :eyebrow="'Calculator · '.$product['name']" :title="$item['short']" :text="$item['summary']" :crumbs="['Calculators' => route('calculators'), $item['name'] => null]" />

    <section class="section" x-data='calculator(@json($slug), @json($assumptions))'>
        <div class="wrap grid gap-8 lg:grid-cols-[1fr_0.9fr] lg:items-start">
            {{-- Inputs --}}
            <div class="card space-y-6" data-reveal>
                <div class="flex items-center justify-between">
                    <h2 class="h-card">Your details</h2>
                    <button type="button" class="link-arrow !text-muted" @click="reset()"><x-icon name="refresh-cw" class="size-3.5" /> Reset</button>
                </div>

                @if ($slug === 'life-cover')
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block"><span class="label">Your age</span><input type="number" class="input" x-model.number="s.age" min="18" max="75"></label>
                        <label class="block"><span class="label">Do you smoke?</span><select class="input" x-model="s.smoker"><option value="no">No</option><option value="yes">Yes</option></select></label>
                    </div>
                    <label class="block">
                        <span class="label flex justify-between">Monthly take-home income <span class="font-bold text-brand-700" x-text="money(s.income)"></span></span>
                        <input type="range" x-model.number="s.income" min="3000" max="60000" step="500">
                    </label>
                    <label class="block">
                        <span class="label flex justify-between">Share of income to replace <span class="font-bold text-brand-700" x-text="s.replacement + '%'"></span></span>
                        <input type="range" x-model.number="s.replacement" min="40" max="100" step="5">
                        <span class="hint">Most families need 60% to 80% once one set of expenses is gone.</span>
                    </label>
                    <label class="block">
                        <span class="label flex justify-between">Years of income to replace <span class="font-bold text-brand-700" x-text="s.years + ' years'"></span></span>
                        <input type="range" x-model.number="s.years" min="1" max="30">
                        <span class="hint">Usually until your youngest dependant is independent.</span>
                    </label>
                    <label class="block">
                        <span class="label flex justify-between">Mortgage and other debts <span class="font-bold text-brand-700" x-text="money(s.debts)"></span></span>
                        <input type="range" x-model.number="s.debts" min="0" max="3000000" step="25000">
                    </label>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block"><span class="label">Children to educate</span><input type="number" class="input" x-model.number="s.dependants" min="0" max="10"></label>
                        <label class="block"><span class="label">Education fund per child (TT$)</span><input type="number" class="input" x-model.number="s.educationPerChild" min="0" step="5000"></label>
                        <label class="block"><span class="label">Savings and investments (TT$)</span><input type="number" class="input" x-model.number="s.savings" min="0" step="5000"></label>
                        <label class="block"><span class="label">Existing life cover (TT$)</span><input type="number" class="input" x-model.number="s.existingCover" min="0" step="25000"></label>
                    </div>
                @elseif ($slug === 'critical-illness')
                    <label class="block">
                        <span class="label flex justify-between">Monthly take-home income <span class="font-bold text-brand-700" x-text="money(s.income)"></span></span>
                        <input type="range" x-model.number="s.income" min="3000" max="60000" step="500">
                    </label>
                    <label class="block">
                        <span class="label flex justify-between">Months you might be off work <span class="font-bold text-brand-700" x-text="s.monthsOff + ' months'"></span></span>
                        <input type="range" x-model.number="s.monthsOff" min="3" max="36">
                        <span class="hint">Cancer treatment and recovery commonly takes 12 to 18 months.</span>
                    </label>
                    <label class="block">
                        <span class="label flex justify-between">Monthly mortgage or rent <span class="font-bold text-brand-700" x-text="money(s.housing)"></span></span>
                        <input type="range" x-model.number="s.housing" min="0" max="25000" step="250">
                    </label>
                    <label class="block">
                        <span class="label flex justify-between">Treatment, travel and care costs <span class="font-bold text-brand-700" x-text="money(s.treatment)"></span></span>
                        <input type="range" x-model.number="s.treatment" min="0" max="1000000" step="10000">
                        <span class="hint">Overseas treatment can run from TT$150,000 to well over TT$500,000.</span>
                    </label>
                    <label class="block"><span class="label">Emergency savings you could use (TT$)</span><input type="number" class="input" x-model.number="s.savings" min="0" step="5000"></label>
                @elseif ($slug === 'retirement')
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block"><span class="label">Your age</span><input type="number" class="input" x-model.number="s.age" min="18" max="69"></label>
                        <label class="block"><span class="label">Retire at</span><input type="number" class="input" x-model.number="s.retireAge" min="52" max="70"><span class="hint">Lifestyle Pensions pay from 52 to 70.</span></label>
                    </div>
                    <label class="block">
                        <span class="label flex justify-between">Monthly contribution <span class="font-bold text-brand-700" x-text="money(s.monthly)"></span></span>
                        <input type="range" x-model.number="s.monthly" min="200" max="10000" step="100">
                    </label>
                    <label class="block">
                        <span class="label flex justify-between">Retirement savings so far <span class="font-bold text-brand-700" x-text="money(s.savings)"></span></span>
                        <input type="range" x-model.number="s.savings" min="0" max="2000000" step="10000">
                    </label>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block"><span class="label">Investment approach</span><select class="input" x-model="s.growth">@foreach ($growthOptions as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select></label>
                        <label class="block"><span class="label">Annual income before tax (TT$)</span><input type="number" class="input" x-model.number="s.annualIncome" min="0" step="5000"></label>
                    </div>
                    <label class="block">
                        <span class="label flex justify-between">Monthly income you want in retirement, in today's money <span class="font-bold text-brand-700" x-text="money(s.targetIncome)"></span></span>
                        <input type="range" x-model.number="s.targetIncome" min="2000" max="40000" step="500">
                    </label>
                @else
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block"><span class="label">Child's age now</span><input type="number" class="input" x-model.number="s.childAge" min="0" max="17"></label>
                        <label class="block"><span class="label">Starts at age</span><input type="number" class="input" x-model.number="s.startAge" min="11" max="25"></label>
                    </div>
                    <fieldset>
                        <legend class="label">Where will they study?</legend>
                        <div class="grid gap-2 sm:grid-cols-3">
                            @foreach (['local' => ['UWI St Augustine or local', $assumptions['education_cost_local']], 'regional' => ['Regional or private', $assumptions['education_cost_regional']], 'abroad' => ['USA, UK or Canada', $assumptions['education_cost_abroad']]] as $k => [$label, $cost])
                                <label class="option"><input type="radio" class="peer sr-only" value="{{ $k }}" x-model="s.option"><span class="flex-col !items-start !gap-0"><span>{{ $label }}</span><span class="text-xs font-medium text-muted">about {{ $money($cost) }} a year today</span></span></label>
                            @endforeach
                        </div>
                    </fieldset>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block"><span class="label">Course length (years)</span><input type="number" class="input" x-model.number="s.courseYears" min="1" max="7"></label>
                        <label class="block"><span class="label">Investment approach</span><select class="input" x-model="s.growth">@foreach ($growthOptions as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select></label>
                    </div>
                    <label class="block"><span class="label">Already saved for this (TT$)</span><input type="number" class="input" x-model.number="s.savings" min="0" step="1000"></label>
                @endif
            </div>

            {{-- Results --}}
            <div class="space-y-5 lg:sticky lg:top-28">
                <div class="relative overflow-hidden rounded-[2rem] bg-ink p-8 text-white shadow-lift" data-reveal>
                    <div class="absolute inset-0 grid-ink opacity-40"></div>
                    <div class="absolute inset-0 glow-brand"></div>
                    <div class="relative">
                        @if ($slug === 'life-cover')
                            <p class="text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Recommended life cover</p>
                            <p class="mt-2 font-display text-4xl font-semibold tracking-tight tabular-nums sm:text-5xl xl:text-6xl" x-text="money(r.recommendedCover)"></p>
                            <p class="mt-3 text-sm text-white/70">Illustrative term premium <strong class="font-bold text-white" x-text="money(r.premiumLow) + ' to ' + money(r.premiumHigh)"></strong> a month. Rachel quotes the real Guardian figure.</p>
                            <div class="mt-6 space-y-3">
                                <template x-for="[label, amount] in r.breakdown" :key="label">
                                    <div>
                                        <div class="flex justify-between text-xs font-semibold text-white/80"><span x-text="label"></span><span x-text="money(amount)"></span></div>
                                        <div class="mt-1 h-2 overflow-hidden rounded-full bg-white/10"><div class="h-full rounded-full bg-gold-400" :style="'width:' + pct(amount, r.totalNeed) + '%'"></div></div>
                                    </div>
                                </template>
                                <div class="flex justify-between border-t border-white/10 pt-3 text-xs font-semibold text-white/60"><span>Less savings and existing cover</span><span x-text="'−' + money(r.offsets)"></span></div>
                            </div>
                        @elseif ($slug === 'critical-illness')
                            <p class="text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Recommended critical illness cover</p>
                            <p class="mt-2 font-display text-4xl font-semibold tracking-tight tabular-nums sm:text-5xl xl:text-6xl" x-text="money(r.recommendedCover)"></p>
                            <p class="mt-3 text-sm text-white/70">Paid to you as a tax-free lump sum on diagnosis, under the Guardian Life Phoenix Plan.</p>
                            <div class="mt-6 space-y-3">
                                <template x-for="[label, amount] in r.breakdown" :key="label">
                                    <div>
                                        <div class="flex justify-between text-xs font-semibold text-white/80"><span x-text="label"></span><span x-text="money(amount)"></span></div>
                                        <div class="mt-1 h-2 overflow-hidden rounded-full bg-white/10"><div class="h-full rounded-full bg-gold-400" :style="'width:' + pct(amount, r.totalNeed) + '%'"></div></div>
                                    </div>
                                </template>
                                <div class="flex justify-between border-t border-white/10 pt-3 text-xs font-semibold text-white/60"><span>Less emergency savings</span><span x-text="'−' + money(s.savings)"></span></div>
                            </div>
                        @elseif ($slug === 'retirement')
                            <p class="text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Projected pot at <span x-text="s.retireAge"></span></p>
                            <p class="mt-2 font-display text-4xl font-semibold tracking-tight tabular-nums sm:text-5xl xl:text-6xl" x-text="money(r.pot)"></p>
                            <p class="mt-3 text-sm text-white/70">Worth about <strong class="font-bold text-white" x-text="money(r.potToday)"></strong> in today's money. Could pay <strong class="font-bold text-white" x-text="money(r.monthlyIncome)"></strong> a month for 25 years.</p>
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <div class="rounded-2xl bg-white/10 p-4"><p class="text-[11px] font-bold tracking-wider text-white/60 uppercase">Tax saved this year</p><p class="mt-1 result-num text-gold-300" x-text="money(r.taxSaving)"></p><p class="mt-1 text-xs text-white/60">Net cost <span x-text="money(r.netMonthlyCost)"></span> a month</p></div>
                                <div class="rounded-2xl bg-white/10 p-4"><p class="text-[11px] font-bold tracking-wider text-white/60 uppercase">Target income</p><p class="mt-1 result-num" x-text="money(r.targetIncomeFuture)"></p><p class="mt-1 text-xs text-white/60">a month in <span x-text="r.years"></span> years</p></div>
                            </div>
                            <div class="mt-4 rounded-2xl p-4 ring-1" :class="r.onTrack ? 'bg-emerald-500/15 ring-emerald-300/40' : 'bg-gold-400/15 ring-gold-300/40'">
                                <p class="flex items-center gap-2 text-sm font-bold"><x-icon name="target" class="size-4" /> <span x-text="r.onTrack ? 'On track for your target income.' : 'Add about ' + money(r.extraMonthlyNeeded) + ' a month to reach your target.'"></span></p>
                            </div>
                        @else
                            <p class="text-[11px] font-bold tracking-[0.18em] text-gold-300 uppercase">Save each month</p>
                            <p class="mt-2 font-display text-4xl font-semibold tracking-tight tabular-nums sm:text-5xl xl:text-6xl" x-text="money(r.monthly)"></p>
                            <p class="mt-3 text-sm text-white/70">For <span x-text="r.yearsUntil"></span> years, to fund <strong class="font-bold text-white" x-text="s.courseYears + ' years'"></strong> of study costing <strong class="font-bold text-white" x-text="money(r.totalCost)"></strong> in total by then.</p>
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <div class="rounded-2xl bg-white/10 p-4"><p class="text-[11px] font-bold tracking-wider text-white/60 uppercase">Annual cost then</p><p class="mt-1 result-num" x-text="money(r.annualFuture)"></p><p class="mt-1 text-xs text-white/60">vs <span x-text="money(r.costToday)"></span> today</p></div>
                                <div class="rounded-2xl bg-white/10 p-4"><p class="text-[11px] font-bold tracking-wider text-white/60 uppercase">Or a lump sum today</p><p class="mt-1 result-num text-gold-300" x-text="money(r.lumpSumToday)"></p><p class="mt-1 text-xs text-white/60">invested once</p></div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Send to Rachel --}}
                <div class="card" id="form-calculator" data-reveal>
                    <h2 class="h-card">Send this estimate to Rachel</h2>
                    <p class="mt-1 text-sm text-muted">She will turn it into real Guardian premiums and reply within one working day.</p>
                    <div class="mt-5">
                        <x-form-status type="calculator" title="Estimate sent." message="Rachel has your numbers and will reply with real premiums." />
                        <form method="POST" action="{{ route('leads.store', 'calculator') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="calculator" value="{{ $slug }}">
                            <input type="hidden" name="inputs" :value="inputsJson">
                            <input type="hidden" name="results" :value="resultsJson">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <x-field name="name" label="Your name" bag="calculator" required autocomplete="name" />
                                <x-field name="phone" label="Phone or WhatsApp" type="tel" bag="calculator" autocomplete="tel" />
                                <x-field name="email" label="Email" type="email" bag="calculator" autocomplete="email" />
                                <x-field name="preferred_contact" label="Reach me by" type="select" bag="calculator" :options="['whatsapp' => 'WhatsApp', 'phone' => 'Phone call', 'email' => 'Email']" value="whatsapp" />
                            </div>
                            <x-consent bag="calculator" />
                            <button class="btn btn-primary w-full">Send my estimate <x-icon name="send" class="size-4" /></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrap mt-12 grid gap-6 lg:grid-cols-[1fr_1fr]">
            <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70 sm:p-8" data-reveal>
                <p class="eyebrow">How this is worked out</p>
                <p class="mt-3 leading-relaxed text-muted">{{ $item['method'] }}</p>
                <p class="mt-3 text-sm text-muted">Assumptions: {{ $assumptions['inflation'] * 100 }}% inflation, growth of {{ $assumptions['growth_conservative'] * 100 }}%, {{ $assumptions['growth_balanced'] * 100 }}% or {{ $assumptions['growth_growth'] * 100 }}%, a {{ $assumptions['tax_rate'] * 100 }}% income tax rate above the TT$90,000 personal allowance, an annuity deduction limit of {{ $money($assumptions['annuity_deduction_limit']) }} and final expenses of {{ $money($assumptions['funeral_cost']) }}. Estimates for discussion, not quotations or advice.</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1 xl:grid-cols-3">
                @foreach ($others as $otherSlug => $other)
                    <a href="{{ route('calculators.show', $otherSlug) }}" class="group rounded-3xl bg-white p-5 ring-1 ring-line/70 transition hover:ring-brand-200" data-reveal>
                        <span class="icon-tile size-10 rounded-xl"><x-icon :name="$other['icon']" class="size-5" /></span>
                        <span class="mt-3 block font-bold">{{ $other['name'] }}</span>
                        <span class="mt-1 block text-xs text-muted">{{ $other['short'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-band :product="$item['product']" :title="'Turn the estimate into a '.strtolower($product['name']).' plan.'" />
</x-layout>
