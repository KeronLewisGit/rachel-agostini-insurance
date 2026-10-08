<x-admin title="Dashboard">
    @php
        $maxLeads = max(1, $days->max('leads'));
        $maxViews = max(1, $days->max('views'));
        $delta = $lastMonth ? round(($thisMonth - $lastMonth) / $lastMonth * 100) : null;
    @endphp
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold tracking-[0.18em] text-brand-700 uppercase">{{ now()->format('l j F Y') }}</p>
            <h1 class="mt-1 font-display text-3xl font-semibold">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ Str::before(auth()->user()->name, ' ') }}.</h1>
            <p class="mt-1 text-sm text-muted">
                @if ($newCount)
                    <strong class="font-bold text-ink">{{ $newCount }} new {{ Str::plural('lead', $newCount) }}</strong> waiting for a first reply{{ $stale ? ", {$stale} older than a day" : '' }}.
                @else
                    Every lead has had a first reply. Nice.
                @endif
            </p>
        </div>
        <a href="{{ route('admin.leads', ['status' => 'new']) }}" class="btn btn-primary">Work the new leads <x-icon name="arrow-right" class="size-4" /></a>
    </div>

    {{-- KPI tiles --}}
    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['Leads this month', $thisMonth, $delta === null ? 'first month' : ($delta >= 0 ? "+{$delta}% vs last month" : "{$delta}% vs last month"), 'inbox'],
            ['Open pipeline', $open, "{$newCount} new, ".($open - $newCount).' in progress', 'activity'],
            ['Policies issued', $won, $conversion !== null ? "{$conversion}% of closed leads" : 'no closed leads yet', 'circle-check'],
            ['Visitors, 30 days', $visitors30, "{$views30} page views", 'eye'],
        ] as [$label, $value, $sub, $icon])
            <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
                <div class="flex items-center justify-between"><p class="text-sm font-semibold text-muted">{{ $label }}</p><x-icon :name="$icon" class="size-5 text-brand-600" /></div>
                <p class="mt-3 font-display text-4xl font-semibold tabular-nums">{{ number_format($value) }}</p>
                <p class="mt-1 text-xs text-muted">{{ $sub }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 *:min-w-0 xl:grid-cols-[1.4fr_1fr]">
        {{-- Leads per day --}}
        <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
            <div class="flex items-center justify-between">
                <div><h2 class="font-display text-xl font-semibold">Leads per day</h2><p class="text-xs text-muted">Last 30 days · {{ $days->sum('leads') }} leads</p></div>
                @if ($responseHours !== null)<p class="chip">Avg first reply {{ $responseHours < 1 ? round($responseHours * 60).' min' : round($responseHours, 1).' h' }}</p>@endif
            </div>
            <div class="mt-5 flex h-40 items-end gap-[3px]" role="img" aria-label="Leads per day for the last 30 days">
                @foreach ($days as $day)
                    <div class="group relative flex-1">
                        <div class="w-full rounded-t-[4px] bg-brand-600 transition group-hover:bg-brand-700" style="height: {{ max(2, round($day['leads'] / $maxLeads * 160)) }}px"></div>
                        <div class="pointer-events-none absolute bottom-full left-1/2 z-10 mb-2 hidden -translate-x-1/2 rounded-lg bg-ink px-2.5 py-1.5 text-xs whitespace-nowrap text-white group-hover:block">{{ \Illuminate\Support\Carbon::parse($day['date'])->format('D j M') }}: {{ $day['leads'] }} {{ Str::plural('lead', $day['leads']) }}</div>
                    </div>
                @endforeach
            </div>
            <div class="mt-2 flex justify-between text-[11px] text-muted"><span>{{ \Illuminate\Support\Carbon::parse($days->first()['date'])->format('j M') }}</span><span>Today</span></div>
            <h3 class="mt-8 text-sm font-bold">Page views per day</h3>
            <div class="mt-3 flex h-20 items-end gap-[3px]" role="img" aria-label="Page views per day for the last 30 days">
                @foreach ($days as $day)
                    <div class="group relative flex-1">
                        <div class="w-full rounded-t-[4px] bg-brand-200 transition group-hover:bg-brand-300" style="height: {{ max(2, round($day['views'] / $maxViews * 80)) }}px"></div>
                        <div class="pointer-events-none absolute bottom-full left-1/2 z-10 mb-2 hidden -translate-x-1/2 rounded-lg bg-ink px-2.5 py-1.5 text-xs whitespace-nowrap text-white group-hover:block">{{ \Illuminate\Support\Carbon::parse($day['date'])->format('D j M') }}: {{ $day['views'] }} views</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Pipeline --}}
        <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
            <h2 class="font-display text-xl font-semibold">Pipeline</h2>
            <p class="text-xs text-muted">All {{ $total }} leads by stage</p>
            <ul class="mt-5 space-y-3">
                @foreach (\App\Models\Lead::STATUSES as $key => $status)
                    @php($count = (int) ($byStatus[$key] ?? 0))
                    <li>
                        <a href="{{ route('admin.leads', ['status' => $key]) }}" class="group block">
                            <div class="flex items-center justify-between text-sm"><span class="font-semibold group-hover:text-brand-700">{{ $status['label'] }}</span><span class="tabular-nums text-muted">{{ $count }}</span></div>
                            <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-paper-deep"><div class="h-full rounded-full bg-brand-600" style="width: {{ $total ? max(1, round($count / $total * 100)) : 0 }}%"></div></div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <h3 class="mt-8 text-sm font-bold">By source</h3>
            <ul class="mt-3 space-y-2 text-sm">
                @forelse ($sources as $source => $count)
                    <li class="flex items-center justify-between"><span class="text-muted">{{ $source }}</span><span class="font-semibold tabular-nums">{{ $count }}</span></li>
                @empty
                    <li class="text-muted">No leads yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="mt-6 grid gap-6 *:min-w-0 xl:grid-cols-[1.4fr_1fr]">
        {{-- Hot leads --}}
        <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
            <div class="flex items-center justify-between"><h2 class="font-display text-xl font-semibold">Hottest open leads</h2><a href="{{ route('admin.leads', ['status' => 'open', 'sort' => 'score']) }}" class="link-arrow">All open <x-icon name="arrow-right" class="size-3.5" /></a></div>
            <div class="mt-4 overflow-x-auto">
                <table class="table-clean">
                    <thead><tr><th>Lead</th><th>About</th><th>Stage</th><th>Score</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($hot as $lead)
                            <tr>
                                <td><a href="{{ route('admin.leads.show', $lead) }}" class="font-bold hover:text-brand-700">{{ $lead->name }}</a><p class="text-xs text-muted">{{ $lead->typeLabel() }} · {{ $lead->created_at->diffForHumans() }}</p></td>
                                <td class="max-w-xs"><p class="font-semibold">{{ $lead->productName() ?? 'General' }}</p><p class="truncate text-xs text-muted">{{ $lead->summary }}</p></td>
                                <td><x-status-badge :lead="$lead" /></td>
                                <td><x-score-pill :score="$lead->score" /></td>
                                <td class="text-right">@if ($lead->whatsappUrl())<a href="{{ $lead->whatsappUrl() }}" target="_blank" rel="noopener" class="btn btn-whatsapp !px-3 !py-1.5 text-xs">WhatsApp</a>@endif</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-muted">No open leads.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="space-y-6">
            <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
                <h2 class="font-display text-xl font-semibold">Most asked about</h2>
                @php($maxProduct = max(1, $byProduct->max()))
                <ul class="mt-4 space-y-3">
                    @forelse ($byProduct as $product => $count)
                        <li>
                            <div class="flex items-center justify-between text-sm"><span class="font-semibold">{{ config("products.items.{$product}.name", $product) }}</span><span class="tabular-nums text-muted">{{ $count }}</span></div>
                            <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-paper-deep"><div class="h-full rounded-full bg-gold-400" style="width: {{ round($count / $maxProduct * 100) }}%"></div></div>
                        </li>
                    @empty
                        <li class="text-sm text-muted">No product enquiries yet.</li>
                    @endforelse
                </ul>
            </div>
            <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
                <h2 class="font-display text-xl font-semibold">Top pages, 30 days</h2>
                <ul class="mt-4 space-y-2 text-sm">
                    @forelse ($topPages as $page)
                        <li class="flex items-center justify-between gap-3"><span class="truncate font-mono text-xs">/{{ ltrim($page->path, '/') === '' ? '' : ltrim($page->path, '/') }}</span><span class="shrink-0 tabular-nums text-muted">{{ $page->total }} <span class="text-xs">({{ $page->visitors }})</span></span></li>
                    @empty
                        <li class="text-muted">No traffic recorded yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-admin>
