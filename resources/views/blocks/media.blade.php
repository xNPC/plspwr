@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? null;
    $body = $content['body'] ?? '';
    $image = $content['image'] ?? null;
    $imageUrl = $image ? \App\Services\ImageHelper::url($image) : null;
    $imageAlt = $content['image_alt'] ?? ($title ?? '');
    $side = $content['side'] ?? 'right'; // image on which side
    $imageRight = $side === 'right';
@endphp

<section id="media-{{ $block->id }}" class="relative py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            @if ($imageUrl)
                <div class="relative order-2 {{ $imageRight ? 'lg:order-2' : 'lg:order-1' }}" data-reveal>
                    <div class="relative rounded-2xl overflow-hidden border border-white/10">
                        <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif
            <div class="order-1 {{ $imageRight ? 'lg:order-1' : 'lg:order-2' }}" data-reveal>
                @if ($eyebrow)
                    <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-400 mb-4">
                        <span class="h-px w-8 bg-accent-400"></span>{{ $eyebrow }}
                    </div>
                @endif
                @if ($title)
                    <h2 class="font-display text-3xl font-bold text-white mb-5">{{ $title }}</h2>
                @endif
                @if ($body)
                    <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed">{!! $body !!}</div>
                @endif
            </div>
        </div>
    </div>
</section>
