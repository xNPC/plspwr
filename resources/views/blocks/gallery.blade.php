@php
    $eyebrow = $content['eyebrow'] ?? null;
    $title = $content['title'] ?? null;
    $text = $content['text'] ?? '';
    $images = $content['images'] ?? [];
@endphp

<section id="gallery-{{ $block->id }}" class="relative py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if ($eyebrow)
            <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-accent-400 mb-4">
                <span class="h-px w-8 bg-accent-400"></span>{{ $eyebrow }}
            </div>
        @endif
        @if ($title)
            <h2 class="font-display text-3xl font-bold text-white mb-4">{{ $title }}</h2>
        @endif
        @if ($text)
            <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed mb-8">{!! $text !!}</div>
        @endif
        @if (is_array($images) && count($images))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($images as $image)
                    @php
                        $imageVal = is_array($image) ? ($image['image'] ?? $image['url'] ?? '') : $image;
                        $imgUrl = $imageVal ? \App\Services\ImageHelper::url($imageVal) : null;
                    @endphp
                    @if ($imgUrl)
                        <div class="relative rounded-2xl overflow-hidden border border-white/10">
                            <img src="{{ $imgUrl }}" alt="{{ $title ?? '' }}" class="w-full h-56 object-cover">
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>
