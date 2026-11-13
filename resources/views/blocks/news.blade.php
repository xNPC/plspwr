@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? __('News');
    $limit = isset($content['limit']) && $content['limit'] ? (int) $content['limit'] : 3;
    $items = ($posts ?? collect())->take($limit);
@endphp

<section id="news" class="relative py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-6 mb-12" data-reveal>
            <div>
                @if ($eyebrow)
                    <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-400 mb-4">
                        <span class="h-px w-8 bg-accent-400"></span>{{ $eyebrow }}
                    </div>
                @endif
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-white">{{ $title }}</h2>
            </div>
            <a href="{{ locale_path('/news') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-accent-400 hover:text-accent-300 transition-colors shrink-0">
                {{ __('All news') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>

        @if ($items->isEmpty())
            <p class="text-center text-slate-500">{{ __('No news yet.') }}</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($items as $item)
                    <article class="group rounded-2xl border border-white/10 bg-ink-900/50 hover:border-accent-500/30 transition-colors overflow-hidden" data-reveal>
                        <a href="{{ $item->url }}" class="block p-6">
                            <div class="text-xs text-slate-500 mb-3">
                                {{ $item->published_at?->translatedFormat('j F Y') }}
                                @if ($item->category === 'event')
                                    <span class="ml-2 inline-block rounded-full bg-glow-500/15 text-glow-400 px-2 py-0.5 text-[11px] uppercase">{{ __('Event') }}</span>
                                @endif
                            </div>
                            <h3 class="font-display text-lg font-semibold text-white group-hover:text-accent-300 transition-colors mb-2">{{ $item->title }}</h3>
                            @if ($item->intro)
                                <p class="text-sm text-slate-400 line-clamp-3">{{ $item->intro }}</p>
                            @endif
                        </a>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
