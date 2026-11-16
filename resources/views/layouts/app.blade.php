<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.partials.seo')

    <script>document.documentElement.classList.add('js');</script>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/svg+xml" href="{{ url('/favicon.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-ink-950 text-slate-200 min-h-screen font-sans antialiased" data-lenis-prevent>
    @php
        $menu = $siteMenu ?? null;
        $menuItems = ($menu && $menu->items) ? $menu->items->where('is_active', true) : collect();
        $topMenuItems = $menuItems->where('parent_id', null);
    @endphp

    @include('layouts.partials.header', ['menuItems' => $topMenuItems])

    <main class="relative pt-[var(--header-height)]">
        {{ $slot }}
    </main>

    @include('layouts.partials.footer', ['menuItems' => $topMenuItems])

    <div x-data id="toast-container" class="fixed bottom-6 right-6 z-[60] space-y-3"></div>

    <canvas id="cursor-glow" class="fixed inset-0 z-[40] h-full w-full pointer-events-none" aria-hidden="true" style="mix-blend-mode: screen"></canvas>

    @livewireScripts
    @stack('scripts')
</body>
</html>
