@php
    $title = $content['title'] ?? __('Frequently asked questions');
    $items = $content['items'] ?? [];
@endphp

<section id="faq-{{ $block->id }}" class="relative py-16">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        @if ($title)
            <h2 class="font-display text-3xl font-bold text-white mb-10 text-center" data-reveal>{{ $title }}</h2>
        @endif

        @if (!empty($items))
            <div class="space-y-4" x-data="{ open: null }">
                @foreach ($items as $index => $item)
                    <div class="rounded-2xl border border-white/10 bg-ink-900/50 overflow-hidden" data-reveal>
                        <button type="button"
                                class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left font-display text-base font-semibold text-white hover:text-accent-300 transition-colors"
                                @click="open = open === {{ $index }} ? null : {{ $index }}">
                            <span>{{ $item['q'] ?? '' }}</span>
                            <svg class="w-5 h-5 text-accent-400 shrink-0 transition-transform" :class="open === {{ $index }} ? 'rotate-45' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                        <div x-show="open === {{ $index }}" x-cloak>
                            <div class="px-6 pb-5 text-sm text-slate-400 leading-relaxed prose prose-invert prose-slate max-w-none">
                                {!! $item['a'] ?? '' !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
