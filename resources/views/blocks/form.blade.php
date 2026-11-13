@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? __('Get in touch');
    $text = $content['text'] ?? '';
@endphp

<section id="form" class="relative py-24 overflow-hidden">
    <div class="pointer-events-none absolute inset-0 bg-ink-900/40"></div>
    <div class="pointer-events-none absolute inset-0 bg-grid opacity-20"></div>
    <div class="pointer-events-none absolute -bottom-32 left-1/2 -translate-x-1/2 h-72 w-[40rem] bg-accent-500/10 blur-3xl rounded-full"></div>

    <div class="relative mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10" data-reveal>
            @if ($eyebrow)
                <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-400 mb-4">
                    <span class="h-px w-8 bg-accent-400"></span>{{ $eyebrow }}<span class="h-px w-8 bg-accent-400"></span>
                </div>
            @endif
            @if ($title)
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4">{{ $title }}</h2>
            @endif
            @if ($text)
                <p class="text-slate-400">{{ $text }}</p>
            @endif
        </div>

        <div data-reveal>
            <livewire:lead-form />
        </div>
    </div>
</section>
