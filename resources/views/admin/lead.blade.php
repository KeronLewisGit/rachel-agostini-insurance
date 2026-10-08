<x-admin :title="$lead->name">
    @php($source = $lead->source ?? [])
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.leads') }}" class="link-arrow !text-muted"><x-icon name="arrow-left" class="size-3.5" /> Back to leads</a>
    <div class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <div class="flex flex-wrap items-center gap-2">
                <h1 class="font-display text-3xl font-semibold">{{ $lead->name }}</h1>
                <x-status-badge :lead="$lead" />
                <x-score-pill :score="$lead->score" />
                @if ($lead->is_sample)<span class="chip">Sample data</span>@endif
            </div>
            <p class="mt-1 text-sm text-muted">{{ $lead->reference }} · {{ $lead->typeLabel() }} · received {{ $lead->created_at->format('l j F Y \a\t g:ia') }} ({{ $lead->created_at->diffForHumans() }})</p>
        </div>
        <div class="flex flex-wrap gap-2">
            @if ($lead->whatsappUrl())<a href="{{ $lead->whatsappUrl() }}?text={{ rawurlencode('Hi '.Str::before($lead->name, ' ').', it\'s Rachel Agostini from Guardian Group. Thanks for your request on my website ('.$lead->reference.'). When is a good time to talk?') }}" target="_blank" rel="noopener" class="btn btn-whatsapp"><x-icon name="message-circle" class="size-4" /> WhatsApp</a>@endif
            @if ($lead->phone)<a href="tel:{{ preg_replace('/[^\d+]/', '', $lead->phone) }}" class="btn btn-light"><x-icon name="phone" class="size-4" /> Call</a>@endif
            @if ($lead->email)<a href="mailto:{{ $lead->email }}?subject={{ rawurlencode('Your insurance request '.$lead->reference) }}" class="btn btn-light"><x-icon name="mail" class="size-4" /> Email</a>@endif
        </div>
    </div>

    {{-- Pipeline --}}
    <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="mt-6 rounded-3xl bg-white p-4 ring-1 ring-line/70">
        @csrf @method('PATCH')
        <p class="px-2 text-xs font-bold tracking-[0.16em] text-muted uppercase">Move to stage</p>
        <div class="mt-2 flex flex-wrap gap-2">
            @foreach (\App\Models\Lead::STATUSES as $key => $status)
                <button name="status" value="{{ $key }}" @class(['inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold ring-1 transition', 'bg-ink text-white ring-ink' => $lead->status === $key, 'bg-white ring-line hover:ring-ink/40' => $lead->status !== $key]) @disabled($lead->status === $key)>
                    @if ($lead->status === $key)<x-icon name="check" class="size-3.5" />@endif {{ $status['label'] }}
                </button>
            @endforeach
        </div>
    </form>

    <div class="mt-6 grid gap-6 *:min-w-0 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="space-y-6">
            {{-- What they sent --}}
            <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
                <h2 class="font-display text-xl font-semibold">What {{ Str::before($lead->name, ' ') }} sent</h2>
                <dl class="mt-4 grid gap-x-6 gap-y-3 text-sm sm:grid-cols-2">
                    <div><dt class="text-xs font-bold tracking-wider text-muted uppercase">Product</dt><dd class="font-semibold">{{ $lead->productName() ?? 'General enquiry' }}</dd></div>
                    <div><dt class="text-xs font-bold tracking-wider text-muted uppercase">Prefers</dt><dd class="font-semibold">{{ $lead->preferred_contact ? Str::headline($lead->preferred_contact) : 'Not stated' }}</dd></div>
                    <div><dt class="text-xs font-bold tracking-wider text-muted uppercase">Phone</dt><dd class="font-semibold">{{ $lead->phone ?? '—' }}</dd></div>
                    <div><dt class="text-xs font-bold tracking-wider text-muted uppercase">Email</dt><dd class="font-semibold break-all">{{ $lead->email ?? '—' }}</dd></div>
                    @foreach (collect($lead->data)->except(['inputs', 'results', 'calculator', 'preferred_contact']) as $key => $value)
                        <div><dt class="text-xs font-bold tracking-wider text-muted uppercase">{{ Str::headline($key) }}</dt><dd class="font-semibold">{{ is_array($value) ? json_encode($value) : Str::headline(str_replace('-', ' ', (string) $value)) }}</dd></div>
                    @endforeach
                </dl>
                @if ($lead->message)
                    <blockquote class="mt-5 rounded-2xl bg-paper p-4 text-sm leading-relaxed">"{{ $lead->message }}"</blockquote>
                @endif
                @if ($calculator)
                    <div class="mt-5 rounded-2xl bg-ink p-5 text-white">
                        <p class="text-[11px] font-bold tracking-[0.16em] text-gold-300 uppercase">{{ $calculator['name'] }}</p>
                        <div class="mt-3 grid gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-xs font-bold text-white/60">Results</p>
                                <dl class="mt-1 space-y-1 text-sm">
                                    @foreach ($lead->data['results'] ?? [] as $key => $value)
                                        <div class="flex justify-between gap-3"><dt class="text-white/70">{{ Str::headline($key) }}</dt><dd class="font-bold tabular-nums">{{ is_numeric($value) ? 'TT$'.number_format((float) $value) : (is_bool($value) ? ($value ? 'Yes' : 'No') : $value) }}</dd></div>
                                    @endforeach
                                </dl>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white/60">Inputs</p>
                                <dl class="mt-1 space-y-1 text-sm">
                                    @foreach ($lead->data['inputs'] ?? [] as $key => $value)
                                        <div class="flex justify-between gap-3"><dt class="text-white/70">{{ Str::headline($key) }}</dt><dd class="font-bold tabular-nums">{{ is_numeric($value) && $value > 200 ? number_format((float) $value) : $value }}</dd></div>
                                    @endforeach
                                </dl>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Activity --}}
            <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
                <h2 class="font-display text-xl font-semibold">Activity</h2>
                <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="mt-4 space-y-3">
                    @csrf @method('PATCH')
                    <div class="flex flex-wrap gap-2">
                        @foreach (['call' => 'Call', 'whatsapp' => 'WhatsApp', 'email' => 'Email', 'meeting' => 'Meeting', 'note' => 'Note'] as $key => $label)
                            <label class="option"><input type="radio" name="activity_type" value="{{ $key }}" class="peer sr-only" @checked($key === 'note')><span class="!py-1.5 text-xs">{{ $label }}</span></label>
                        @endforeach
                    </div>
                    <textarea name="activity" rows="2" class="input" placeholder="Log a call, a WhatsApp, a quote sent…" required></textarea>
                    <button class="btn btn-dark !py-2">Add to timeline</button>
                </form>
                <ol class="mt-6 space-y-4 border-l-2 border-line pl-5">
                    @foreach ($lead->activities as $activity)
                        <li class="relative">
                            <span class="absolute -left-[1.65rem] top-1 grid size-5 place-items-center rounded-full bg-white ring-2 ring-brand-200"><span class="size-2 rounded-full bg-brand-600"></span></span>
                            <p class="text-sm">{{ $activity->body }}</p>
                            <p class="mt-0.5 text-xs text-muted">{{ Str::headline($activity->type) }} · {{ $activity->created_at->format('j M Y, g:ia') }}{{ $activity->user ? ' · '.$activity->user->name : '' }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Notes --}}
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
                @csrf @method('PATCH')
                <h2 class="font-display text-xl font-semibold">Notes and premium</h2>
                <label class="mt-4 block"><span class="label">Estimated annual premium (TT$)</span><input type="number" name="estimated_premium" value="{{ old('estimated_premium', $lead->estimated_premium) }}" class="input" min="0" step="100"></label>
                <label class="mt-4 block"><span class="label">Private notes</span><textarea name="notes" rows="6" class="input" placeholder="Health details, family situation, what was quoted…">{{ old('notes', $lead->notes) }}</textarea></label>
                <button class="btn btn-primary mt-4 w-full">Save</button>
            </form>

            {{-- Source --}}
            <div class="rounded-3xl bg-white p-6 ring-1 ring-line/70">
                <h2 class="font-display text-xl font-semibold">Where this lead came from</h2>
                <dl class="mt-4 space-y-2 text-sm">
                    @foreach ([
                        'Source' => $lead->sourceLabel(),
                        'Campaign' => $source['utm_campaign'] ?? null,
                        'Content' => $source['utm_content'] ?? null,
                        'Landing page' => isset($source['landing_page']) ? '/'.ltrim($source['landing_page'], '/') : null,
                        'Form page' => $source['form_page'] ?? null,
                        'Pages viewed' => $source['pages_viewed'] ?? null,
                        'Device' => isset($source['device']) ? Str::headline($source['device']) : null,
                        'First visit' => isset($source['first_seen']) ? \Illuminate\Support\Carbon::parse($source['first_seen'])->format('j M Y, g:ia') : null,
                    ] as $label => $value)
                        @if ($value)
                            <div class="flex justify-between gap-4"><dt class="text-muted">{{ $label }}</dt><dd class="text-right font-semibold">{{ $value }}</dd></div>
                        @endif
                    @endforeach
                </dl>
                <div class="mt-4 space-y-1 border-t border-line pt-4 text-xs text-muted">
                    @if ($lead->contacted_at)<p>First contacted {{ $lead->contacted_at->diffForHumans($lead->created_at, syntax: \Carbon\CarbonInterface::DIFF_ABSOLUTE) }} after arriving.</p>@endif
                    @if ($lead->closed_at)<p>Closed {{ $lead->closed_at->format('j M Y') }}.</p>@endif
                </div>
            </div>

            <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('Delete this lead permanently?')" class="text-right">
                @csrf @method('DELETE')
                <button class="link-arrow !text-rose-700"><x-icon name="trash-2" class="size-3.5" /> Delete lead</button>
            </form>
        </div>
    </div>
</x-admin>
