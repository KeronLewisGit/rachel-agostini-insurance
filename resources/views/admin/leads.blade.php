<x-admin title="Leads">
    @php($tabs = ['' => 'All', 'new' => 'New', 'open' => 'Open', 'contacted' => 'Contacted', 'quoted' => 'Quoted', 'won' => 'Issued', 'lost' => 'Closed'])
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold">Leads</h1>
            <p class="mt-1 text-sm text-muted">{{ $leads->total() }} {{ Str::plural('lead', $leads->total()) }} match. Click a name to open the full record.</p>
        </div>
        <a href="{{ route('admin.leads.export', request()->query()) }}" class="btn btn-light"><x-icon name="download" class="size-4" /> Export this view</a>
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
        @foreach ($tabs as $key => $label)
            @php($count = $key === '' ? $counts->sum() : ($key === 'open' ? $counts->only(\App\Models\Lead::OPEN_STATUSES)->sum() : ($counts[$key] ?? 0)))
            <a href="{{ route('admin.leads', array_filter(array_merge($filters, ['status' => $key, 'page' => null]))) }}" @class(['inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold ring-1 transition', 'bg-ink text-white ring-ink' => ($filters['status'] ?? '') === $key, 'bg-white ring-line hover:ring-ink/40' => ($filters['status'] ?? '') !== $key])>
                {{ $label }} <span class="text-xs opacity-60">{{ $count }}</span>
            </a>
        @endforeach
    </div>

    <form method="GET" class="mt-4 grid gap-3 rounded-3xl bg-white p-4 ring-1 ring-line/70 sm:grid-cols-[1fr_auto_auto_auto_auto]">
        <input type="hidden" name="status" value="{{ $filters['status'] ?? '' }}">
        <label class="relative"><x-icon name="search" class="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted" /><input type="search" name="q" value="{{ $filters['q'] ?? '' }}" class="input !pl-9" placeholder="Search name, phone, email, reference"></label>
        <select name="type" class="input"><option value="">All types</option>@foreach (\App\Models\Lead::TYPES as $key => $type)<option value="{{ $key }}" @selected(($filters['type'] ?? '') === $key)>{{ $type['label'] }}</option>@endforeach</select>
        <select name="product" class="input"><option value="">All products</option>@foreach ($products as $key => $name)<option value="{{ $key }}" @selected(($filters['product'] ?? '') === $key)>{{ $name }}</option>@endforeach</select>
        <select name="sort" class="input"><option value="">Newest first</option><option value="score" @selected(($filters['sort'] ?? '') === 'score')>Highest score</option></select>
        <button class="btn btn-dark">Filter</button>
    </form>

    <div class="mt-4 overflow-x-auto rounded-3xl bg-white ring-1 ring-line/70">
        <table class="table-clean">
            <thead><tr><th>Lead</th><th>Type</th><th>About</th><th>Source</th><th>Stage</th><th>Score</th><th>Received</th><th></th></tr></thead>
            <tbody>
                @forelse ($leads as $lead)
                    <tr class="transition hover:bg-paper/60">
                        <td>
                            <a href="{{ route('admin.leads.show', $lead) }}" class="font-bold hover:text-brand-700">{{ $lead->name }}</a>
                            <p class="text-xs text-muted">{{ $lead->reference }}@if ($lead->is_sample) · sample @endif</p>
                            <p class="mt-1 text-xs text-muted">{{ $lead->phone }}{{ $lead->phone && $lead->email ? ' · ' : '' }}{{ $lead->email }}</p>
                        </td>
                        <td><span class="inline-flex items-center gap-1.5 text-sm font-semibold"><x-icon :name="$lead->typeIcon()" class="size-4 text-brand-600" /> {{ $lead->typeLabel() }}</span></td>
                        <td class="max-w-xs"><p class="font-semibold">{{ $lead->productName() ?? 'General' }}</p><p class="truncate text-xs text-muted" title="{{ $lead->summary }}">{{ $lead->summary }}</p></td>
                        <td class="text-sm text-muted">{{ $lead->sourceLabel() }}<p class="text-xs">{{ $lead->source['device'] ?? '' }}</p></td>
                        <td><x-status-badge :lead="$lead" /></td>
                        <td><x-score-pill :score="$lead->score" /></td>
                        <td class="text-sm whitespace-nowrap text-muted" title="{{ $lead->created_at->format('j M Y, g:ia') }}">{{ $lead->created_at->diffForHumans(short: true) }}</td>
                        <td class="text-right whitespace-nowrap">
                            @if ($lead->whatsappUrl())<a href="{{ $lead->whatsappUrl() }}" target="_blank" rel="noopener" class="btn btn-whatsapp !px-3 !py-1.5 text-xs">WhatsApp</a>@endif
                            <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-light !px-3 !py-1.5 text-xs">Open</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="py-12 text-center text-muted">No leads match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $leads->links() }}</div>
</x-admin>
