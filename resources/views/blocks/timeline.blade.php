@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? __('Our journey');
    $description = $content['description'] ?? null;
    $items = $content['items'] ?? [];
@endphp

<section id="timeline" class="relative py-24 overflow-hidden">
    <div class="pointer-events-none absolute inset-0 bg-ink-900/40"></div>
    <div class="pointer-events-none absolute inset-0 bg-grid opacity-20"></div>

    <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16" data-reveal>
            @if ($eyebrow)
                <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-400 mb-4">
                    <span class="h-px w-8 bg-accent-400"></span>{{ $eyebrow }}<span class="h-px w-8 bg-accent-400"></span>
                </div>
            @endif
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4">{{ $title }}</h2>
            @if ($description)
                <p class="text-slate-400">{{ $description }}</p>
            @endif
        </div>

        @if (!empty($items))
            <div class="relative">
                <div class="absolute left-4 md:left-1/2 md:-translate-x-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-accent-500/40 via-glow-500/40 to-transparent"></div>

                <div class="space-y-12">
                    @foreach ($items as $index => $item)
                        @php
                            $year = $item['year'] ?? '';
                            $text = $item['text'] ?? '';
                            $left = $index % 2 === 0;
                        @endphp
                        <div class="relative flex md:justify-between items-start gap-6" data-reveal>
                            {{-- Node --}}
                            <div class="absolute left-4 md:left-1/2 -translate-x-1/2 top-1 h-3 w-3 rounded-full bg-accent-400 ring-4 ring-accent-500/20"></div>

                            {{-- Card --}}
                            <div class="ml-12 md:ml-0 {{ $left ? 'md:pr-12 md:text-right md:mr-auto' : 'md:pl-12 md:ml-auto' }} md:w-1/2">
                                <div class="inline-block rounded-xl border border-white/10 bg-ink-900/60 p-6 hover:border-accent-500/30 transition-colors">
                                    <div class="font-display text-3xl font-bold gradient-text mb-3">{{ $year }}</div>
                                    @if ($text)
                                        <p class="text-sm text-slate-300 leading-relaxed">{{ $text }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
