<x-layouts.app>
    <section class="relative py-28 overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" data-reveal>
            <nav class="text-xs text-slate-500 mb-6" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ localized_route('home') }}" class="hover:text-accent-400 transition-colors">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ localized_route('applications.index') }}" class="hover:text-accent-400 transition-colors">{{ __('Applications') }}</a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">{{ $application->title }}</span>
            </nav>
        </div>
    </section>

    <section class="relative pb-28">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @php $img = \App\Services\ImageHelper::url($application->image); @endphp
            @if ($img)
                <div class="relative aspect-[16/8] rounded-2xl overflow-hidden border border-white/10 mb-10" data-reveal>
                    <img src="{{ $img }}" alt="{{ $application->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <h1 class="font-display text-4xl font-bold text-white mb-6" data-reveal>{{ $application->title }}</h1>

            @if ($application->intro)
                <p class="text-lg text-slate-300 mb-6 leading-relaxed" data-reveal>{{ $application->intro }}</p>
            @endif

            @if ($application->description)
                <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed" data-reveal>{!! $application->description !!}</div>
            @endif
        </div>
    </section>
</x-layouts.app>
