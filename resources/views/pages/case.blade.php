<x-layouts.app>
    <section class="relative py-28 overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
        <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8" data-reveal>
            <nav class="text-xs text-slate-500 mb-6" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ localized_route('home') }}" class="hover:text-accent-400 transition-colors">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ localized_route('cases.index') }}" class="hover:text-accent-400 transition-colors">{{ __('Case studies') }}</a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">{{ $case->title }}</span>
            </nav>
        </div>
    </section>

    <section class="relative pb-28">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @php $img = \App\Services\ImageHelper::url($case->image); @endphp
            @if ($img)
                <div class="relative aspect-[16/9] rounded-2xl overflow-hidden border border-white/10 mb-10" data-reveal>
                    <img src="{{ $img }}" alt="{{ $case->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <h1 class="font-display text-4xl font-bold text-white mb-6" data-reveal>{{ $case->title }}</h1>

            @if ($case->intro)
                <p class="text-lg text-slate-300 mb-6 leading-relaxed" data-reveal>{{ $case->intro }}</p>
            @endif

            @if ($case->body)
                <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed" data-reveal>{!! $case->body !!}</div>
            @endif
        </div>
    </section>
</x-layouts.app>
