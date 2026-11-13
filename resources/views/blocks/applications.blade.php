@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? __('Application areas');
    $description = $content['description'] ?? null;
    $items = $applications ?? collect();
@endphp

<section id="applications" class="relative py-24 overflow-hidden">
    <div class="pointer-events-none absolute inset-0 bg-ink-900/40"></div>
    <div class="pointer-events-none absolute inset-0 bg-grid opacity-25"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
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
            <p class="text-center text-slate-500">{{ __('No applications yet.') }}</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($items as $item)
                    <a href="{{ $item->url }}" class="group relative rounded-2xl overflow-hidden border border-white/10 bg-ink-900/60 hover:border-glow-500/40 hover:bg-ink-800/60 transition-all duration-300 hover:-translate-y-1" data-reveal>
                        <div class="relative aspect-[16/9] overflow-hidden bg-ink-800">
                            @php $img = \App\Services\ImageHelper::url($item->image); @endphp
                            @if ($img)
                                <img src="{{ $img }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 bg-grid opacity-40 flex items-center justify-center">
                                    <span class="font-display text-5xl font-bold text-white/15">{{ mb_substr($item->title ?? '?', 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-transparent to-transparent"></div>
                            @if (! $img)
                                <div class="absolute top-3 left-3 flex h-10 w-10 items-center justify-center rounded-xl bg-ink-950/70 backdrop-blur border border-white/10">
                                    @php $icon = $item->icon ?? null; $iconUrl = $icon ? \App\Services\ImageHelper::url($icon) : null; @endphp
                                    @if ($iconUrl)
                                        <img src="{{ $iconUrl }}" class="h-5 w-5 object-contain" alt="">
                                    @else
                                        <svg class="h-5 w-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-display text-lg font-semibold text-white mb-2 group-hover:text-glow-400 transition-colors">{{ $item->title }}</h3>
                            @if ($item->intro)
                                <p class="text-sm text-slate-400 line-clamp-2">{{ $item->intro }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
