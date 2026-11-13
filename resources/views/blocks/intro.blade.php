@php
    $eyebrow = $content['eyebrow'] ?? __('About us');
    $title = $content['title'] ?? __('Over 40 years in pulsed power');
    $text = $content['text'] ?? '';
    $image = $content['image'] ?? null;
    $imageUrl = $image ? \App\Services\ImageHelper::url($image) : null;
    $linkLabel = $content['link_label'] ?? '';
    $linkUrl = $content['link_url'] ?? '';
    $link2Label = $content['link2_label'] ?? '';
    $link2Url = $content['link2_url'] ?? '';
@endphp

<section id="intro" class="relative py-24 overflow-hidden">
    <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="order-2 lg:order-1" data-reveal>
                @if ($eyebrow)
                    <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-400 mb-4">
                        <span class="h-px w-8 bg-accent-400"></span>{{ $eyebrow }}
                    </div>
                @endif
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
                    {{ $title }}
                </h2>
                @if ($text)
                    <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed mb-8">{!! $text !!}</div>
                @endif
                @if ($linkLabel || $link2Label)
                    <div class="flex flex-wrap gap-4">
                        @if ($linkLabel)
                            <a href="{{ locale_path($linkUrl) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-accent-400 hover:text-accent-300 transition-colors">
                                {{ $linkLabel }}
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @endif
                        @if ($link2Label)
                            <a href="{{ $link2Url }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-300 hover:text-white transition-colors">
                                {{ $link2Label }}
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <div class="order-1 lg:order-2 relative" data-reveal>
                @if ($imageUrl)
                    <div class="relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl shadow-accent-500/10">
                        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-ink-950/40 to-transparent"></div>
                    </div>
                @else
                    <div class="relative aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-ink-800 to-ink-900 border border-white/10 flex items-center justify-center">
                        <div class="absolute inset-0 bg-grid opacity-50"></div>
                        <div class="absolute inset-0 bg-radial-fade"></div>
                        <div class="relative text-center px-8">
                            <div class="text-6xl font-display font-bold text-white/20 mb-2">40+</div>
                            <div class="text-sm text-slate-400">{{ __('years in pulsed power') }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
