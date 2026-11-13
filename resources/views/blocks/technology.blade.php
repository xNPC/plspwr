@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? __('Leadership in solid-state technologies');
    $text = $content['text'] ?? '';
    $image = $content['image'] ?? null;
    $imageUrl = $image ? \App\Services\ImageHelper::url($image) : null;
    $linkLabel = $content['link_label'] ?? __('Technology');
    $linkUrl = $content['link_url'] ?? url('/technology');
    $link2Label = $content['link2_label'] ?? '';
    $link2Url = $content['link2_url'] ?? '';
    $points = $content['points'] ?? [];
@endphp

<section id="technology" class="relative py-24 overflow-hidden">
    <div class="pointer-events-none absolute -right-40 top-1/2 -translate-y-1/2 h-[30rem] w-[30rem] bg-glow-500/10 blur-3xl rounded-full"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="relative order-1 lg:order-2" data-reveal>
                @if ($imageUrl)
                    <div class="relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl shadow-glow-500/10">
                        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="relative aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-accent-500/10 via-ink-800 to-glow-500/10 border border-white/10">
                        <div class="absolute inset-0 bg-grid opacity-40"></div>
                        <div class="absolute inset-0 bg-radial-fade"></div>
                        <div class="absolute bottom-6 left-6 flex items-center gap-3 text-sm text-white">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-glow-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-glow-400"></span>
                            </span>
                            {{ __('Solid-state technology') }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="order-2 lg:order-1" data-reveal>
                @if ($eyebrow)
                    <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-glow-400 mb-4">
                        <span class="h-px w-8 bg-glow-400"></span>{{ $eyebrow }}
                    </div>
                @endif
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
                    {{ $title }}
                </h2>
                @if ($text)
                    <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed mb-8">{!! $text !!}</div>
                @endif

                @if ($points)
                    <ul class="space-y-3 mb-8">
                        @foreach ($points as $point)
                            @php
                                $pointText = is_array($point) ? ($point['point'] ?? '') : (string) $point;
                            @endphp
                            <li class="flex items-start gap-3 text-slate-300">
                                <svg class="w-5 h-5 text-glow-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ $pointText }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($linkLabel)
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ locale_path($linkUrl) }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-accent-500 to-glow-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-glow-500/20 hover:brightness-110 transition-all">
                            {{ $linkLabel }}
                        </a>
                        @if ($link2Label)
                            <a href="{{ locale_path($link2Url) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-300 hover:text-white transition-colors">
                                {{ $link2Label }}
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
