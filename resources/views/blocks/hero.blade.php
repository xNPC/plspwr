@php
    $title = $content['title'] ?? __('Pulsed power engineering');
    $subtitle = $content['subtitle'] ?? __('Systems ahead of time');
    $text = $content['text'] ?? '';
    $primaryLabel = $content['primary_label'] ?? __('Our developments');
    $primaryUrl = $content['primary_url'] ?? url('/products');
    $secondaryLabel = $content['secondary_label'] ?? __('Contacts');
    $secondaryUrl = $content['secondary_url'] ?? url('/contacts');
    $badge = $content['badge'] ?? __('NPP Impulse Technologies');
@endphp

<section id="hero" class="relative min-h-[var(--hero-min-height)] flex flex-col overflow-hidden">
    {{-- Animated SVG impulse background --}}
    <div class="absolute inset-0 z-0 overflow-hidden">
        @include('partials.hero-fon')
    </div>

    {{-- Overlays --}}
    <div class="absolute inset-0 z-[1] bg-grid opacity-40"></div>
    <div class="absolute inset-0 z-[1] bg-gradient-to-b from-ink-950/70 via-transparent to-ink-950"></div>
    <div class="absolute -top-32 left-1/2 -translate-x-1/2 z-[1] h-96 w-[48rem] bg-radial-fade"></div>

    {{-- Independent pulse waveform animation (resources/js/pulse.js) --}}
    <canvas id="pulse" class="absolute inset-0 z-[2] h-full w-full" aria-hidden="true" style="pointer-events:none"></canvas>

    {{-- Hero logo (below the fixed header, slides up into the menu on scroll) --}}
    @if ($siteSettings->image('brand.logo'))
        <div class="relative z-[5] pt-3">
            <a href="{{ localized_route('home') }}" id="hero-logo"
               class="block transition-all duration-500 will-change-transform motion-reduce:transition-none"
               aria-label="{{ config('app.name') }}">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <img src="{{ $siteSettings->image('brand.logo') }}" alt="{{ config('app.name') }}"
                         class="h-16 sm:h-20 w-auto">
                </div>
            </a>
        </div>
    @endif

    <div class="relative z-10 flex-1 flex flex-col items-center justify-center mx-auto max-w-5xl w-full px-4 sm:px-6 lg:px-8 text-center pt-4 pb-20">
        @if ($badge)
            <div class="inline-flex items-center gap-2 rounded-full border border-accent-500/30 bg-accent-500/5 px-5 py-2 text-lg font-medium uppercase tracking-widest text-accent-300 mb-8" data-reveal>
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-accent-400"></span>
                </span>
                {{ $badge }}
            </div>
        @endif

        <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6" data-reveal>
            <span class="block font-medium">{{ $title }}</span>
            <span class="block gradient-text">{{ $subtitle }}</span>
        </h1>

        @if ($text)
            <p class="max-w-3xl mx-auto text-xl sm:text-2xl lg:text-2xl text-slate-100 leading-relaxed mb-10" data-reveal>
                {{ $text }}
            </p>
        @endif

        {{-- data-pulse-anchor: the waveform in resources/js/pulse.js is drawn a
             fixed distance below this row, so the CTA ↔ pulse spacing no longer
             depends on the browser viewport height. --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4" data-reveal data-pulse-anchor>
            @if ($primaryLabel)
                <a href="{{ locale_path($primaryUrl) }}" class="group inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-accent-500 to-glow-500 px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-accent-500/25 hover:shadow-accent-500/40 hover:brightness-110 transition-all">
                    {{ $primaryLabel }}
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            @endif
            @if ($secondaryLabel)
                <a href="{{ locale_path($secondaryUrl) }}" class="inline-flex items-center gap-2 rounded-lg border border-white/15 bg-white/5 px-7 py-3.5 text-sm font-semibold text-white backdrop-blur hover:bg-white/10 transition-all">
                    {{ $secondaryLabel }}
                </a>
            @endif
        </div>
    </div>

    {{-- Scroll indicator --}}
    <a href="#intro" class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 text-slate-400 hover:text-white transition-colors" aria-label="{{ __('Scroll down') }}">
        <span class="text-xs uppercase tracking-widest">Scroll</span>
        <span class="flex h-9 w-5 items-start justify-center rounded-full border border-white/20 p-1">
            <span class="h-2 w-1 rounded-full bg-accent-400 animate-scroll-down"></span>
        </span>
    </a>
</section>
