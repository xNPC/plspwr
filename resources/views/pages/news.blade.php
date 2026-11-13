<x-layouts.app>
    @php
        $bannerTitle = $category === 'event' ? __('Events') : ($page?->title ?: __('News'));
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
            @if ($posts->isEmpty())
                <p class="text-center text-slate-500">{{ __('No posts yet.') }}</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                        <article class="group rounded-2xl border border-white/10 bg-ink-900/50 hover:border-accent-500/30 transition-colors overflow-hidden" data-reveal>
                            <a href="{{ $post->url }}" class="block">
                                @php $img = \App\Services\ImageHelper::url($post->image); @endphp
                                @if ($img)
                                    <div class="relative aspect-[16/10] overflow-hidden bg-ink-800">
                                        <img src="{{ $img }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                @endif
                                <div class="p-6">
                                    <div class="text-xs text-slate-500 mb-2">{{ $post->published_at?->translatedFormat('j F Y') }}</div>
                                    <h2 class="font-display text-lg font-semibold text-white group-hover:text-accent-300 transition-colors mb-2">{{ $post->title }}</h2>
                                    @if ($post->intro)
                                        <p class="text-sm text-slate-400 line-clamp-3">{{ $post->intro }}</p>
                                    @endif
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>

    @include('blocks.listing', ['page' => $page ?? null])
</x-layouts.app>
