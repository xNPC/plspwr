<x-layouts.app>
    <section class="relative py-28 overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
        <div class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 h-64 w-[36rem] bg-accent-500/10 blur-3xl rounded-full"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" data-reveal>
            <nav class="text-xs text-slate-500 mb-4" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ localized_route('home') }}" class="hover:text-accent-400 transition-colors">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ localized_route('products.index') }}" class="hover:text-accent-400 transition-colors">{{ __('Products') }}</a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">{{ $family->title }}</span>
            </nav>
            @if ($family->code)
                <div class="font-mono text-sm text-accent-400 mb-2">{{ $family->code }}</div>
            @endif
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-white">{{ $family->title }}</h1>
        </div>
    </section>

    <section class="relative pb-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($family->description)
                <div class="prose prose-invert prose-slate max-w-3xl mb-12" data-reveal>{!! $family->description !!}</div>
            @endif

            @if ($products->isEmpty())
                <p class="text-slate-500">{{ __('No products in this category yet.') }}</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <a href="{{ $product->url }}" class="group rounded-2xl border border-white/10 bg-ink-900/50 hover:border-accent-500/40 transition-all duration-300 hover:-translate-y-1 overflow-hidden" data-reveal>
                            <div class="relative aspect-[4/3] overflow-hidden bg-ink-800">
                                @php $img = \App\Services\ImageHelper::url($product->gallery[0] ?? null); @endphp
                                @if ($img)
                                    <img src="{{ $img }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 bg-grid opacity-40 flex items-center justify-center">
                                        <span class="font-display text-4xl font-bold text-white/15">{{ $product->code ?? mb_substr($product->title ?? '?', 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                @if ($product->code)
                                    <div class="font-mono text-xs text-accent-400 mb-1">{{ $product->code }}</div>
                                @endif
                                <h2 class="font-display text-lg font-semibold text-white group-hover:text-accent-300 transition-colors">{{ $product->title }}</h2>
                                @if ($product->intro)
                                    <p class="mt-2 text-sm text-slate-400 line-clamp-3">{{ $product->intro }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
