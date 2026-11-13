<x-layouts.app>
    @php
        $bannerTitle = $page?->title ?: __('Products');
    @endphp
    @include('partials.page-banner', [
        'title' => $bannerTitle,
        'description' => $page?->description,
        'image' => $page?->banner_image,
        'breadcrumbs' => [
            ['label' => __('Home'), 'url' => localized_route('home')],
            ['label' => $bannerTitle],
        ],
    ])

    <section class="relative pb-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($families->isEmpty())
                <p class="text-center text-slate-500">{{ __('No products yet.') }}</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($families as $family)
                        <a href="{{ $family->url }}" class="group relative rounded-2xl overflow-hidden border border-white/10 bg-ink-900/60 hover:border-accent-500/40 transition-all duration-300 hover:-translate-y-1" data-reveal>
                            <div class="relative aspect-[16/8] overflow-hidden bg-ink-800">
                                @php $img = \App\Services\ImageHelper::url($family->image); @endphp
                                @if ($img)
                                    <img src="{{ $img }}" alt="{{ $family->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 bg-grid opacity-40 flex items-center justify-center">
                                        <span class="font-display text-5xl font-bold text-white/15">{{ $family->code ?? mb_substr($family->title ?? '?', 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-ink-950/30 to-transparent"></div>
                            </div>
                            <div class="p-6 -mt-12 relative">
                                @if ($family->code)
                                    <div class="font-mono text-sm text-accent-400 mb-1">{{ $family->code }}</div>
                                @endif
                                <h2 class="font-display text-2xl font-semibold text-white group-hover:text-accent-300 transition-colors">{{ $family->title }}</h2>
                                @if ($family->intro)
                                    <p class="mt-2 text-sm text-slate-400">{{ $family->intro }}</p>
                                @endif
                                <div class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-accent-400 group-hover:gap-2 transition-all">
                                    {{ __('Explore') }}
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @include('blocks.listing', ['page' => $page ?? null])
</x-layouts.app>
