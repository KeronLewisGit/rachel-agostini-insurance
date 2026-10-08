@props(['title'])
@php
    $current = Route::currentRouteName();
    $newCount = \App\Models\Lead::where('status', 'new')->count();
    $links = [
        ['admin.dashboard', 'Dashboard', 'layout-dashboard', ['admin.dashboard'], 0],
        ['admin.leads', 'Leads', 'inbox', ['admin.leads', 'admin.leads.show'], $newCount],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} · Lead tracker</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/mark.svg') }}">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-paper-deep/60 lg:flex">
    <aside class="flex shrink-0 flex-col bg-ink text-white lg:sticky lg:top-0 lg:h-screen lg:w-64">
        <div class="flex items-center justify-between gap-3 p-5">
            <a href="{{ route('admin.dashboard') }}"><x-logo light compact /></a>
            <span class="rounded-full bg-white/10 px-2.5 py-1 text-[10px] font-bold tracking-widest uppercase">Lead tracker</span>
        </div>
        <nav class="flex gap-1 overflow-x-auto px-3 pb-3 lg:flex-1 lg:flex-col lg:pb-0" aria-label="Admin">
            @foreach ($links as [$route, $label, $icon, $active, $badge])
                <a href="{{ route($route) }}" @class(['flex shrink-0 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition', 'bg-white text-ink' => in_array($current, $active), 'text-white/70 hover:bg-white/10 hover:text-white' => ! in_array($current, $active)])>
                    <x-icon :name="$icon" class="size-[18px]" /> {{ $label }}
                    @if ($badge)
                        <span class="ml-auto rounded-full bg-gold-400 px-2 py-0.5 text-[11px] font-bold text-ink">{{ $badge }}</span>
                    @endif
                </a>
            @endforeach
            <a href="{{ route('admin.leads', ['status' => 'open', 'sort' => 'score']) }}" class="flex shrink-0 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white"><x-icon name="flame" class="size-[18px]" /> Hot leads</a>
            <a href="{{ route('admin.leads.export') }}" class="flex shrink-0 items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white"><x-icon name="download" class="size-[18px]" /> Export CSV</a>
        </nav>
        <div class="hidden space-y-1 border-t border-white/10 p-3 lg:block">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white"><x-icon name="external-link" class="size-[18px]" /> View website</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="flex w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white"><x-icon name="log-out" class="size-[18px]" /> Sign out</button>
            </form>
            <p class="px-3.5 pt-2 text-xs text-white/40">{{ auth()->user()->name }}</p>
        </div>
    </aside>
    <main class="min-w-0 flex-1 p-5 sm:p-8 lg:p-10">
        @if (session('saved'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900 ring-1 ring-emerald-200" role="status"><x-icon name="check" class="size-4" /> Saved.</div>
        @endif
        {{ $slot }}
    </main>
</body>
</html>
