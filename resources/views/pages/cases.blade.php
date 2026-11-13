<x-layouts.app>
    @php
        $bannerTitle = $page?->title ?: __('Case studies');
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
            @if ($cases->isEmpty())
                <p class="text-center text-slate-500">{{ __('No case studies yet.') }}</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($cases as $case)
                        <a href="{{ $case->url }}" class="group rounded-2xl overflow-hidden border border-white/10 bg-ink-900/60 hover:border-accent-500/40 transition-all duration-300 hover:-translate-y-1" data-reveal>
                            <div class="relative aspect-[16/10] overflow-hidden bg-ink-800">
                                @php $img = \App\Services\ImageHelper::url($case->image); @endphp
                                @if ($img)
                                    <img src="{{ $img }}" alt="{{ $case->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 bg-grid opacity-40 flex items-center justify-center">
                                        <span class="font-display text-4xl font-bold text-white/15">{{ mb_substr($case->title ?? '?', 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-transparent to-transparent"></div>
                            </div>
                            <div class="p-6 -mt-10 relative">
                                <h2 class="font-display text-lg font-semibold text-white group-hover:text-accent-300 transition-colors">{{ $case->title }}</h2>
                                @if ($case->intro)
                                    <p class="mt-2 text-sm text-slate-400 line-clamp-2">{{ $case->intro }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @include('blocks.listing', ['page' => $page ?? null])
</x-layouts.app>
