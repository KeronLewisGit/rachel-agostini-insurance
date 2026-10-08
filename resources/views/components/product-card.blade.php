@props(['slug', 'item', 'compact' => false])
<a href="{{ route('products.show', $slug) }}" {{ $attributes->merge(['class' => 'group relative flex h-full flex-col rounded-3xl bg-white p-6 shadow-card ring-1 ring-line/70 transition duration-300 hover:-translate-y-1 hover:shadow-lift hover:ring-brand-200']) }}>
    <span class="icon-tile transition group-hover:bg-brand-600 group-hover:text-white">
        <x-icon :name="$item['icon']" class="size-6" />
    </span>
    <span class="mt-5 block text-[11px] font-bold tracking-[0.16em] text-brand-700 uppercase">{{ $item['eyebrow'] }}</span>
    <span class="mt-1.5 block h-card">{{ $item['name'] }}</span>
    @unless ($compact)
        <span class="mt-2 block text-sm leading-relaxed text-muted">{{ $item['summary'] }}</span>
    @endunless
    <span class="mt-auto flex items-center justify-between pt-5">
        <span class="text-xs font-semibold text-muted">{{ $item['company'] }}</span>
        <span class="grid size-9 place-items-center rounded-full bg-paper text-ink transition group-hover:bg-gold-400">
            <x-icon name="arrow-up-right" class="size-4" />
        </span>
    </span>
</a>
