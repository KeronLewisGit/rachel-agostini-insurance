@props(['light' => false, 'compact' => false])
<span {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-brand-600 font-display text-lg font-bold text-white shadow-sm ring-2 ring-gold-400/80">RA</span>
    @unless ($compact)
        <span class="leading-tight">
            <span class="block font-display text-lg font-semibold {{ $light ? 'text-white' : 'text-ink' }}">Rachel Agostini</span>
            <span class="block text-[11px] font-bold tracking-[0.16em] uppercase {{ $light ? 'text-gold-300' : 'text-brand-700' }}">Guardian Life of the Caribbean</span>
        </span>
    @endunless
</span>
