@php
    $title = $content['title'] ?? __('Technology for results. Always close by.');
    $text = $content['text'] ?? '';
    $primaryLabel = $content['primary_label'] ?? __('Work with us');
    $primaryUrl = $content['primary_url'] ?? url('/contacts');
    $secondaryLabel = $content['secondary_label'] ?? __('Contacts');
    $secondaryUrl = $content['secondary_url'] ?? url('/contacts');
@endphp

<section id="cta" class="relative py-24 overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-accent-500/10 via-glow-500/10 to-accent-500/10"></div>
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 h-64 w-[36rem] bg-accent-500/15 blur-3xl rounded-full"></div>
    </div>

    <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center" data-reveal>
        <h2 class="font-display text-3xl sm:text-5xl font-bold text-white leading-tight mb-6">{{ $title }}</h2>
        @if ($text)
            <p class="max-w-2xl mx-auto text-slate-300 text-lg mb-10">{{ $text }}</p>
        @endif
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @if ($primaryLabel)
                <a href="{{ locale_path($primaryUrl) }}" class="group inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-accent-500 to-glow-500 px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-accent-500/25 hover:shadow-accent-500/40 hover:brightness-110 transition-all">
                    {{ $primaryLabel }}
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            @endif
            @if ($secondaryLabel)
                <a href="{{ locale_path($secondaryUrl) }}" class="inline-flex items-center gap-2 rounded-lg border border-white/15 bg-white/5 px-8 py-4 text-sm font-semibold text-white hover:bg-white/10 transition-all">
                    {{ $secondaryLabel }}
                </a>
            @endif
        </div>
    </div>
</section>
