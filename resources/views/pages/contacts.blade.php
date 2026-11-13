<x-layouts.app>
    @php
        $bannerTitle = $page?->title ?: __('Contacts');
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
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                {{-- Contact info --}}
                <div class="space-y-5" data-reveal>
                    @if ($siteSettings->get('contacts.phone'))
                        <a href="tel:{{ $siteSettings->get('contacts.phone') }}" class="flex items-center gap-4 rounded-2xl border border-white/10 bg-ink-900/50 p-6 hover:border-accent-500/30 transition-colors group">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-accent-500/20 to-glow-500/20 border border-accent-500/20">
                                <svg class="h-6 w-6 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">{{ __('Phone') }}</div>
                                <div class="font-display text-lg font-semibold text-white group-hover:text-accent-300 transition-colors">{{ $siteSettings->get('contacts.phone') }}</div>
                            </div>
                        </a>
                    @endif

                    @if ($siteSettings->get('contacts.email'))
                        <a href="mailto:{{ $siteSettings->get('contacts.email') }}" class="flex items-center gap-4 rounded-2xl border border-white/10 bg-ink-900/50 p-6 hover:border-accent-500/30 transition-colors group">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-accent-500/20 to-glow-500/20 border border-accent-500/20">
                                <svg class="h-6 w-6 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">{{ __('Email') }}</div>
                                <div class="font-display text-lg font-semibold text-white group-hover:text-accent-300 transition-colors">{{ $siteSettings->get('contacts.email') }}</div>
                            </div>
                        </a>
                    @endif

                    @if ($siteSettings->get('contacts.address_' . app()->getLocale()))
                        <div class="flex items-center gap-4 rounded-2xl border border-white/10 bg-ink-900/50 p-6">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-accent-500/20 to-glow-500/20 border border-accent-500/20">
                                <svg class="h-6 w-6 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">{{ __('Address') }}</div>
                                <div class="font-display text-lg font-semibold text-white">{{ $siteSettings->get('contacts.address_' . app()->getLocale()) }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($siteSettings->get('contacts.work_hours_' . app()->getLocale()))
                        <div class="flex items-center gap-4 rounded-2xl border border-white/10 bg-ink-900/50 p-6">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-accent-500/20 to-glow-500/20 border border-accent-500/20">
                                <svg class="h-6 w-6 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">{{ __('Working hours') }}</div>
                                <div class="font-display text-lg font-semibold text-white">{{ $siteSettings->get('contacts.work_hours_' . app()->getLocale()) }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Form --}}
                <div data-reveal>
                    <livewire:lead-form />
                </div>
            </div>
        </div>
    </section>

    @include('blocks.listing', ['page' => $page ?? null])
</x-layouts.app>
