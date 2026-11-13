@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? __('Our track record');
    $stats = $content['stats'] ?? [
        ['value' => 3500, 'suffix' => '', 'label' => __('Systems delivered')],
        ['value' => 190, 'suffix' => '', 'label' => __('Orders')],
        ['value' => 47, 'suffix' => '', 'label' => __('Countries')],
        ['value' => 4071000, 'suffix' => '', 'label' => __('Operation hours')],
    ];
@endphp

<section id="stats" class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-accent-500/5 via-glow-500/5 to-accent-500/5"></div>
    <div class="pointer-events-none absolute inset-0 bg-grid opacity-20"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12" data-reveal>
            @if ($eyebrow)
                <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-400 mb-4">
                    <span class="h-px w-8 bg-accent-400"></span>{{ $eyebrow }}<span class="h-px w-8 bg-accent-400"></span>
                </div>
            @endif
            @if ($title)
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-white">{{ $title }}</h2>
            @endif
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($stats as $stat)
                @php
                    $value = $stat['value'] ?? 0;
                    $decimals = $stat['decimals'] ?? 0;
                    $suffix = $stat['suffix'] ?? '';
                    $label = $stat['label'] ?? '';
                @endphp
                <div class="text-center" data-reveal>
                    <div class="font-display text-4xl sm:text-5xl font-bold gradient-text" data-counter="{{ $value }}" data-decimals="{{ $decimals }}" data-suffix="{{ $suffix }}">0</div>
                    <div class="mt-2 text-sm text-slate-400">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
