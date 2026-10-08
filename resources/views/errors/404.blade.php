<x-layout title="Page not found" :noindex="true">
    <section class="section">
        <div class="wrap max-w-xl text-center">
            <p class="eyebrow justify-center">404</p>
            <h1 class="mt-3 h-section">That page is not covered.</h1>
            <p class="mt-4 lead">The link may be old or mistyped. Everything Rachel arranges is one click away.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-primary">Back to the home page</a>
                <a href="{{ route('products') }}" class="btn btn-light">Browse insurance</a>
            </div>
        </div>
    </section>
</x-layout>
