@props(['score'])
@php($tone = $score >= 75 ? 'bg-rose-50 text-rose-700 ring-rose-200' : ($score >= 55 ? 'bg-gold-50 text-gold-700 ring-gold-200' : 'bg-slate-100 text-slate-600 ring-slate-200'))
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-bold tabular-nums ring-1 '.$tone]) }} title="Priority score out of 100">
    @if ($score >= 75)<x-icon name="flame" class="size-3" />@endif{{ $score }}
</span>
