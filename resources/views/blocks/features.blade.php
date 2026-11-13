@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? __('Why choose us');
    $description = $content['description'] ?? null;
    $items = $content['items'] ?? [];
    $columns = $content['columns'] ?? 3;
    $gridClass = match ((int) $columns) {
        2 => 'md:grid-cols-2',
        4 => 'md:grid-cols-2 lg:grid-cols-4',
        default => 'md:grid-cols-2 lg:grid-cols-3',
    };
@endphp

<section id="features-{{ $block->id }}" class="relative py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14" data-reveal>
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
            <div class="grid grid-cols-1 {{ $gridClass }} gap-6">
                @foreach ($items as $item)
                    @php
                        $icon = $item['icon'] ?? null;
                        $featureTitle = $item['title'] ?? '';
                        $featureText = $item['text'] ?? '';
                    @endphp
                    <div class="rounded-2xl border border-white/10 bg-ink-900/50 p-6 hover:border-accent-500/30 hover:bg-ink-800/60 transition-all duration-300" data-reveal>
                        @if ($icon)
                            <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-lg bg-gradient-to-br from-accent-500/20 to-glow-500/20 border border-accent-500/20">
                                @if (\Illuminate\Support\Str::startsWith($icon, '<'))
                                    {!! $icon !!}
                                @else
                                    <span class="text-accent-400 font-display font-semibold">{{ $icon }}</span>
                                @endif
                            </div>
                        @endif
                        <h3 class="font-display text-lg font-semibold text-white mb-2">{{ $featureTitle }}</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">{{ $featureText }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
