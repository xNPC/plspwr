@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? __('Products & Solutions');
    $description = $content['description'] ?? null;
    $limit = isset($content['limit']) && $content['limit'] ? (int) $content['limit'] : null;
    $items = $products ?? collect();
    if ($limit) {
        $items = $items->take($limit);
    }
@endphp

<section id="products" class="relative py-24">
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

        @if ($items->isEmpty())
            <p class="text-center text-slate-500">{{ __('No products yet.') }}</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($items as $item)
                    <a href="{{ $item->url }}" class="group relative rounded-2xl overflow-hidden border border-white/10 bg-ink-900/60 hover:border-accent-500/40 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-accent-500/10" data-reveal>
                        <div class="relative aspect-[4/3] overflow-hidden bg-ink-800">
                            @php $img = \App\Services\ImageHelper::url($item->image); @endphp
                            @if ($img)
                                <img src="{{ $img }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 bg-grid opacity-40"></div>
                                <div class="absolute inset-0 bg-radial-fade flex items-center justify-center">
                                    <span class="font-display text-4xl font-bold text-white/15">{{ $item->code ?? mb_substr($item->title ?? '?', 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-ink-950/20 to-transparent"></div>
                        </div>
                        <div class="p-5">
                            @if ($item->code)
                                <div class="text-xs font-mono text-accent-400 mb-1">{{ $item->code }}</div>
                            @endif
                            <h3 class="font-display text-lg font-semibold text-white group-hover:text-accent-300 transition-colors mb-2">{{ $item->title }}</h3>
                            @if ($item->intro)
                                <p class="text-sm text-slate-400 line-clamp-3">{{ $item->intro }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
