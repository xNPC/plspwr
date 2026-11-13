<x-layouts.app>
    <section class="relative py-28 overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
        <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8" data-reveal>
            <nav class="text-xs text-slate-500 mb-6" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ localized_route('home') }}" class="hover:text-accent-400 transition-colors">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ $post->category === 'event' ? localized_route('events.index') : localized_route('news.index') }}" class="hover:text-accent-400 transition-colors">
                    {{ $post->category === 'event' ? __('Events') : __('News') }}
                </a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">{{ $post->title }}</span>
            </nav>
        </div>
    </section>

    <article class="relative pb-28">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="text-xs text-slate-500 mb-4" data-reveal>{{ $post->published_at?->translatedFormat('j F Y') }}</div>
            <h1 class="font-display text-4xl font-bold text-white mb-8" data-reveal>{{ $post->title }}</h1>

            @php $img = \App\Services\ImageHelper::url($post->image); @endphp
            @if ($img)
                <div class="relative aspect-[16/8] rounded-2xl overflow-hidden border border-white/10 mb-8" data-reveal>
                    <img src="{{ $img }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            @if ($post->intro)
                <p class="text-xl text-slate-300 leading-relaxed mb-8" data-reveal>{{ $post->intro }}</p>
            @endif

            @if ($post->body)
                <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed" data-reveal>{!! $post->body !!}</div>
            @endif

            <div class="mt-12 pt-6 border-t border-white/10">
                <a href="{{ localized_route('news.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-accent-400 hover:text-accent-300 transition-colors">
                    <svg class="w-4 h-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    {{ __('Back to news') }}
                </a>
            </div>
        </div>
    </article>
</x-layouts.app>
