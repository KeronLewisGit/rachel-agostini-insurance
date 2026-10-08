@props(['light' => false])
{{-- Guardian Group logo, linking to myguardiangroup.com. Pass "light" on dark backgrounds. --}}
<a href="{{ config('site.links.guardian') }}" target="_blank" rel="noopener" aria-label="Guardian Group website (opens in a new tab)" {{ $attributes->merge(['class' => 'inline-flex shrink-0 items-center transition hover:opacity-80']) }}>
    @if ($light)
        <img src="{{ asset('images/guardian-group-white.webp') }}" alt="Guardian Group" class="h-full w-auto" width="812" height="367" decoding="async">
    @else
        <img src="{{ asset('images/guardian-group.webp') }}" alt="Guardian Group" class="h-full w-auto" width="812" height="367" decoding="async">
    @endif
</a>
