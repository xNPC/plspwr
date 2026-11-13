@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? null;
    $body = $content['body'] ?? '';
    $align = $content['align'] ?? 'left';
    $maxWidth = $content['max_width'] ?? 'prose';
    $widthClass = match ($maxWidth) {
        'narrow' => 'max-w-2xl',
        'wide' => 'max-w-4xl',
        default => 'max-w-3xl',
    };
@endphp

<section id="text-{{ $block->id }}" class="relative py-16">
    <div class="mx-auto {{ $widthClass }} px-4 sm:px-6 lg:px-8 {{ $align === 'center' ? 'text-center' : '' }}" data-reveal>
        @if ($title)
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-6">{{ $title }}</h2>
        @elseif ($eyebrow)
            <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-400 mb-4">
                <span class="h-px w-8 bg-accent-400"></span>{{ $eyebrow }}
            </div>
        @endif
        @if ($body)
            <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed">{!! $body !!}</div>
        @endif
    </div>
</section>
