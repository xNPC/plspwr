@php
    $bannerImage = \App\Services\ImageHelper::url($image ?? null);
    $bannerTitle = $title ?? null;
    $bannerDescription = $description ?? null;
    $bannerBreadcrumbs = $breadcrumbs ?? [];
@endphp

@if ($bannerImage)
    <section class="relative isolate overflow-hidden">
        <img src="{{ $bannerImage }}" alt="{{ $bannerTitle }}"
             class="absolute inset-0 h-full w-full object-cover object-center"
             loading="eager" fetchpriority="high" decoding="async">
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-ink-950 via-ink-950/60 to-ink-950/30"></div>
        <div class="pointer-events-none absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-ink-950/80 to-transparent"></div>

        <div class="relative mx-auto flex min-h-[38vh] max-w-7xl flex-col items-center justify-end px-4 pb-14 pt-24 text-center sm:min-h-[46vh] sm:px-6 sm:pb-20 lg:min-h-[56vh] lg:px-8 lg:pb-24" data-reveal>
            @if (! empty($bannerBreadcrumbs))
                <nav class="mb-4 text-xs text-slate-300/80" aria-label="{{ __('Breadcrumb') }}">
                    @foreach ($bannerBreadcrumbs as $crumb)
                        @if (! $loop->first)
                            <span class="mx-2 text-slate-500">/</span>
                        @endif
                        @if (! empty($crumb['url']))
                            <a href="{{ $crumb['url'] }}" class="transition-colors hover:text-accent-300">{{ $crumb['label'] }}</a>
                        @else
                            <span class="text-slate-200">{{ $crumb['label'] }}</span>
                        @endif
                    @endforeach
                </nav>
            @endif

            <h1 class="font-display text-4xl font-bold text-white drop-shadow-lg sm:text-5xl">{{ $bannerTitle }}</h1>

            @if ($bannerDescription)
                <p class="mx-auto mt-4 max-w-2xl text-slate-200/90">{{ $bannerDescription }}</p>
            @endif
        </div>
    </section>
@else
    <section class="relative py-28 overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
        <div class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 h-64 w-[36rem] bg-accent-500/10 blur-3xl rounded-full"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center" data-reveal>
            @if (! empty($bannerBreadcrumbs))
                <nav class="mb-4 text-xs text-slate-500" aria-label="{{ __('Breadcrumb') }}">
                    @foreach ($bannerBreadcrumbs as $crumb)
                        @if (! $loop->first)
                            <span class="mx-2">/</span>
                        @endif
                        @if (! empty($crumb['url']))
                            <a href="{{ $crumb['url'] }}" class="transition-colors hover:text-accent-400">{{ $crumb['label'] }}</a>
                        @else
                            <span class="text-slate-300">{{ $crumb['label'] }}</span>
                        @endif
                    @endforeach
                </nav>
            @endif

            <h1 class="font-display text-4xl sm:text-5xl font-bold text-white">{{ $bannerTitle }}</h1>

            @if ($bannerDescription)
                <p class="mt-4 text-slate-400 max-w-2xl mx-auto">{{ $bannerDescription }}</p>
            @endif
        </div>
    </section>
@endif
