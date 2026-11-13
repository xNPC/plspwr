<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Page not found') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/svg+xml" href="{{ url('/favicon.svg') }}">

    @vite(['resources/css/app.css'])
</head>
<body class="bg-ink-950 text-slate-200 min-h-screen font-sans antialiased">
    <section class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden px-4 py-24">
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
        <div class="pointer-events-none absolute -top-32 left-1/2 -translate-x-1/2 h-72 w-[40rem] bg-accent-500/10 blur-3xl rounded-full"></div>

        <div class="relative text-center">
            <div class="font-display text-8xl sm:text-9xl font-bold text-transparent bg-gradient-to-b from-white to-slate-600 bg-clip-text">404</div>
            <h1 class="mt-6 font-display text-3xl sm:text-4xl font-bold text-white">{{ __('Page not found') }}</h1>
            <p class="mt-4 text-slate-400 max-w-md mx-auto">{{ __('The page you are looking for was moved, removed, or never existed.') }}</p>
            <a href="{{ localized_route('home') }}" class="mt-10 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-accent-500 to-glow-500 px-8 py-3 font-semibold text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V10"/></svg>
                {{ __('Back to home') }}
            </a>
        </div>
    </section>
</body>
</html>