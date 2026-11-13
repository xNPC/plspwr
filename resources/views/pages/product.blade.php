<x-layouts.app>
    <section class="relative py-28 overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" data-reveal>
            <nav class="text-xs text-slate-500 mb-6" aria-label="{{ __('Breadcrumb') }}">
                <a href="{{ localized_route('home') }}" class="hover:text-accent-400 transition-colors">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ localized_route('products.index') }}" class="hover:text-accent-400 transition-colors">{{ __('Products') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ $family->url }}" class="hover:text-accent-400 transition-colors">{{ $family->title }}</a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">{{ $product->title }}</span>
            </nav>
        </div>
    </section>

    <section class="relative pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                {{-- Gallery --}}
                @php
                    $gallery = $product->gallery ?? [];
                    $mainImg = $gallery ? \App\Services\ImageHelper::url($gallery[0] ?? null) : null;
                    $mainImgJs = $mainImg ? json_encode($mainImg) : '""';
                @endphp
                <div class="space-y-4" data-reveal x-data='{ main: {!! $mainImgJs !!} }'>
                    <div class="relative aspect-[4/3] rounded-2xl overflow-hidden border border-white/10 bg-ink-900">
                        @if ($mainImg)
                            <img :src="main" alt="{{ $product->title }}" class="w-full h-full object-cover" transition>
                        @else
                            <div class="absolute inset-0 bg-grid opacity-40 flex items-center justify-center">
                                <span class="font-display text-6xl font-bold text-white/15">{{ $product->code ?? mb_substr($product->title ?? '?', 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    @if (count($gallery) > 1)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach ($gallery as $img)
                                @php $thumb = \App\Services\ImageHelper::url($img); @endphp
                                @if ($thumb)
                                    <button type="button" @click='main = {!! json_encode($thumb) !!}' :class="main === {!! json_encode($thumb) !!} ? 'ring-2 ring-accent-500 border-accent-500/60' : 'border-white/10'" class="aspect-square rounded-xl overflow-hidden border bg-ink-900 cursor-pointer hover:border-accent-500/50 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500">
                                        <img src="{{ $thumb }}" alt="" class="w-full h-full object-cover">
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Details --}}
                <div data-reveal>
                    @if ($product->code)
                        <div class="font-mono text-sm text-accent-400 mb-2">{{ $product->code }}</div>
                    @endif
                    <h1 class="font-display text-3xl sm:text-4xl font-bold text-white mb-6">{{ $product->title }}</h1>
                    @if ($product->description)
                        <div class="prose prose-invert prose-slate max-w-none text-slate-300 mb-8 leading-relaxed">{!! $product->description !!}</div>
                    @endif

                    <div class="mb-8">
                        <a href="#form" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-accent-500 to-glow-500 px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-accent-500/25 hover:brightness-110 transition-all">
                            {{ __('Request a quote') }}
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Specifications --}}
            @if (!empty($product->specifications))
                <div class="mt-16" data-reveal>
                    <h2 class="font-display text-2xl font-bold text-white mb-6">{{ __('Specifications') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($product->specifications as $spec)
                            @php
                                $locale = app()->getLocale();
                                $name = $spec['name_'.$locale] ?? $spec['name_ru'] ?? $spec['name'] ?? '';
                                $value = $spec['value_'.$locale] ?? $spec['value_ru'] ?? $spec['value'] ?? '';
                            @endphp
                            <div class="flex items-center justify-between gap-4 rounded-xl border border-white/10 bg-ink-900/50 px-5 py-4">
                                <span class="text-sm text-slate-400">{{ $name }}</span>
                                <span class="text-sm font-semibold text-white text-right">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Documentation --}}
            @php
                $documents = $documents ?? collect();
            @endphp
            @if ($documents->isNotEmpty())
                <div class="mt-16" data-reveal>
                    <h2 class="font-display text-2xl font-bold text-white mb-6">{{ __('Documentation') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($documents as $att)
                            @php
                                $ext = strtolower((string) ($att->extension ?? ''));
                                $fileUrl = \App\Services\ImageHelper::url($att->id);

                                $badge = match (true) {
                                    $ext === 'pdf' => 'border-red-500/30 bg-red-500/10 text-red-400',
                                    in_array($ext, ['doc', 'docx', 'rtf', 'odt']) => 'border-sky-500/30 bg-sky-500/10 text-sky-400',
                                    in_array($ext, ['xls', 'xlsx', 'csv', 'ods']) => 'border-emerald-500/30 bg-emerald-500/10 text-emerald-400',
                                    in_array($ext, ['ppt', 'pptx', 'odp']) => 'border-orange-500/30 bg-orange-500/10 text-orange-400',
                                    in_array($ext, ['zip', 'rar', '7z', 'gz', 'tar']) => 'border-amber-500/30 bg-amber-500/10 text-amber-400',
                                    in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'bmp', 'avif']) => 'border-violet-500/30 bg-violet-500/10 text-violet-400',
                                    default => 'border-white/15 bg-white/5 text-slate-400',
                                };

                                $size = (int) ($att->size ?? 0);
                                $sizeLabel = match (true) {
                                    $size >= 1073741824 => number_format($size / 1073741824, 1, '.', '').' '.__('GB'),
                                    $size >= 1048576 => number_format($size / 1048576, 1, '.', '').' '.__('MB'),
                                    $size >= 1024 => number_format($size / 1024, 0, '.', '').' '.__('KB'),
                                    default => $size.' '.__('B'),
                                };
                            @endphp
                            @if ($fileUrl)
                                <a href="{{ $fileUrl }}"
                                   target="_blank" rel="noopener"
                                   class="group flex items-center gap-4 rounded-xl border border-white/10 bg-ink-900/50 px-5 py-4 transition-colors hover:border-accent-500/50">
                                    <span class="inline-flex min-w-12 shrink-0 items-center justify-center rounded-lg border px-2 py-1.5 text-[11px] font-bold uppercase tracking-wide {{ $badge }}">
                                        {{ $ext !== '' ? $ext : __('File') }}
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold text-white transition-colors group-hover:text-accent-300">{{ $att->original_name }}</span>
                                        <span class="block text-xs text-slate-500">{{ strtoupper($ext) }} &middot; {{ $sizeLabel }}</span>
                                    </span>
                                    <svg class="h-4 w-4 shrink-0 text-slate-500 transition-colors group-hover:text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <span class="sr-only">{{ __('Download') }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include('blocks.form', ['block' => null, 'content' => [
        'eyebrow' => __('Contact us'),
        'title' => __('Any questions?'),
        'text' => __('Contact us — we will answer any product questions.'),
    ]])
</x-layouts.app>
