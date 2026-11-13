@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? __('Case studies');
    $description = $content['description'] ?? null;
    $limit = isset($content['limit']) && $content['limit'] ? (int) $content['limit'] : 3;
    $items = ($cases ?? collect())->take($limit);
@endphp

<section id="cases" class="relative py-24 overflow-hidden">
    <div class="pointer-events-none absolute inset-0 bg-ink-900/40"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-6 mb-12" data-reveal>
            <div class="max-w-2xl">
                @if ($eyebrow)
                    <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-400 mb-4">
                        <span class="h-px w-8 bg-accent-400"></span>{{ $eyebrow }}
                    </div>
                @endif
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-white">{{ $title }}</h2>
                @if ($description)
                    <p class="mt-3 text-slate-400">{{ $description }}</p>
                @endif
            </div>
            <a href="{{ locale_path('/cases') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-accent-400 hover:text-accent-300 transition-colors shrink-0">
                {{ __('View all') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>

        @if ($items->isEmpty())
            <p class="text-center text-slate-500">{{ __('No case studies yet.') }}</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($items as $item)
                    <a href="{{ $item->url }}" class="group relative rounded-2xl overflow-hidden border border-white/10 bg-ink-900/60 hover:border-accent-500/40 transition-all duration-300 hover:-translate-y-1" data-reveal>
                        <div class="relative aspect-[16/10] overflow-hidden bg-ink-800">
                            @php $img = \App\Services\ImageHelper::url($item->image); @endphp
                            @if ($img)
                                <img src="{{ $img }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 bg-grid opacity-40 flex items-center justify-center">
                                    <span class="font-display text-3xl font-bold text-white/20">{{ mb_substr($item->title ?? '?', 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-transparent to-transparent"></div>
                        </div>
                        <div class="p-5 -mt-10 relative">
                            <h3 class="font-display text-lg font-semibold text-white group-hover:text-accent-300 transition-colors">{{ $item->title }}</h3>
                            @if ($item->intro)
                                <p class="mt-2 text-sm text-slate-400 line-clamp-2">{{ $item->intro }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
