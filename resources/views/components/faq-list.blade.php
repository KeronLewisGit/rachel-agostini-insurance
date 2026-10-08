@props(['faqs'])
<div {{ $attributes->merge(['class' => 'divide-y divide-line rounded-3xl bg-white shadow-card ring-1 ring-line/70']) }}>
    @foreach ($faqs as $faq)
        <details class="group px-6 py-5 sm:px-8" @if ($loop->first) open @endif>
            <summary class="flex list-none items-center justify-between gap-4 text-left font-semibold">
                <span itemprop="name">{{ $faq['q'] }}</span>
                <span class="grid size-8 shrink-0 place-items-center rounded-full bg-paper transition group-open:rotate-180 group-open:bg-brand-600 group-open:text-white">
                    <x-icon name="chevron-down" class="size-4" />
                </span>
            </summary>
            <p class="mt-3 max-w-3xl leading-relaxed text-muted">{{ $faq['a'] }}</p>
        </details>
    @endforeach
</div>
