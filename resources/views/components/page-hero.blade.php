@props(['eyebrow' => null, 'title', 'text' => null, 'crumbs' => []])
<section class="relative overflow-hidden bg-ink text-white">
    <div class="absolute inset-0 grid-ink opacity-50"></div>
    <div class="absolute inset-0 glow-brand"></div>
    <div class="wrap relative py-14 sm:py-20">
        @if ($crumbs)
            <nav aria-label="Breadcrumb" class="mb-6 text-xs font-semibold text-white/50">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                    @foreach ($crumbs as $label => $url)
                        <li aria-hidden="true">/</li>
                        <li>@if ($url)<a href="{{ $url }}" class="hover:text-white">{{ $label }}</a>@else<span class="text-white/80">{{ $label }}</span>@endif</li>
                    @endforeach
                </ol>
            </nav>
        @endif
        @if ($eyebrow)
            <p class="eyebrow eyebrow-light">{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-3 max-w-4xl h-display">{{ $title }}</h1>
        @if ($text)
            <p class="mt-5 max-w-2xl text-lg text-white/70 sm:text-xl">{{ $text }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
