<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Sign in · Lead tracker</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/mark.svg') }}">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative grid min-h-screen place-items-center overflow-hidden bg-ink p-5 text-ink">
    <div class="absolute inset-0 grid-ink opacity-50"></div>
    <div class="absolute inset-0 glow-brand"></div>
    <div class="relative w-full max-w-sm rounded-[2rem] bg-white p-8 shadow-lift">
        <x-logo />
        <h1 class="mt-6 font-display text-2xl font-semibold">Lead tracker</h1>
        <p class="mt-1 text-sm text-muted">Sign in to see enquiries, estimates and call-back requests.</p>
        <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4">
            @csrf
            <x-field name="email" label="Email" type="email" required autocomplete="email" autofocus />
            <x-field name="password" label="Password" type="password" required autocomplete="current-password" />
            <label class="flex items-center gap-2 text-sm text-muted"><input type="checkbox" name="remember" value="1" class="size-4 rounded border-line text-brand-600"> Keep me signed in</label>
            <button class="btn btn-primary w-full">Sign in</button>
        </form>
        <a href="{{ route('home') }}" class="link-arrow mt-6 !text-muted"><x-icon name="arrow-left" class="size-3.5" /> Back to the website</a>
    </div>
</body>
</html>
