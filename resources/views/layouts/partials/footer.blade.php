@props([
    'menuItems' => [],
    'footerMenuItems' => [],
])

<footer class="relative border-t border-white/5 bg-ink-900/60 overflow-hidden">
    <div class="pointer-events-none absolute inset-0 bg-grid opacity-40"></div>
    <div class="pointer-events-none absolute -top-40 left-1/2 -translate-x-1/2 h-80 w-[40rem] bg-accent-500/10 blur-3xl rounded-full"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 gap-12 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
            {{-- Brand --}}
            <div class="lg:col-span-1">
                <a href="{{ localized_route('home') }}" class="flex items-center gap-3 mb-4">
                    @if ($siteSettings->image('brand.logo'))
                        <img src="{{ $siteSettings->image('brand.logo') }}" alt="{{ config('app.name') }}" class="h-9 w-auto">
                    @else
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-accent-500 to-glow-500 font-bold text-white">IT</span>
                    @endif
                </a>
                <p class="text-sm text-slate-400 leading-relaxed">
                    {{ $siteSettings->get('brand.tagline_' . app()->getLocale()) ?? 'Производство высоковольтных импульсных модуляторов и систем импульсной энергетики.' }}
                </p>
            </div>

            @php
                $rootItems = $menuItems->where('parent_id', null)->where('is_active', true);
                $columnItems = $rootItems->filter(fn ($item) => $item->children->where('is_active', true)->isNotEmpty());
                $flatItems = $rootItems->reject(fn ($item) => $item->children->where('is_active', true)->isNotEmpty());
            @endphp

            {{-- Menu categories (mirror of top menu) --}}
            @foreach ($columnItems as $item)
                <div>
                    <h3 class="font-display text-sm font-semibold text-white mb-4 uppercase tracking-wider">{{ $item->label }}</h3>
                    <ul class="space-y-2.5">
                        @foreach ($item->children->where('is_active', true) as $child)
                            <li>
                                <a href="{{ $child->url ?? '#' }}" class="text-sm text-slate-400 hover:text-accent-400 transition-colors">
                                    {{ $child->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            {{-- Single links --}}
            @if ($flatItems->isNotEmpty())
                <div>
                    <h3 class="font-display text-sm font-semibold text-white mb-4 uppercase tracking-wider">{{ __('Navigation') }}</h3>
                    <ul class="space-y-2.5">
                        @foreach ($flatItems as $item)
                            <li>
                                <a href="{{ $item->url ?? '#' }}" class="text-sm text-slate-400 hover:text-accent-400 transition-colors">
                                    {{ $item->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Contacts --}}
            <div>
                <h3 class="font-display text-sm font-semibold text-white mb-4 uppercase tracking-wider">{{ __('Contacts') }}</h3>
                <ul class="space-y-2.5 text-sm">
                    @if ($siteSettings->get('contacts.phone'))
                        <li class="flex items-start gap-2 text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <a href="tel:{{ $siteSettings->get('contacts.phone') }}" class="hover:text-white transition-colors">{{ $siteSettings->get('contacts.phone') }}</a>
                        </li>
                    @endif
                    @if ($siteSettings->get('contacts.email'))
                        <li class="flex items-start gap-2 text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <a href="mailto:{{ $siteSettings->get('contacts.email') }}" class="hover:text-white transition-colors">{{ $siteSettings->get('contacts.email') }}</a>
                        </li>
                    @endif
                    @if ($siteSettings->get('contacts.address_' . app()->getLocale()))
                        <li class="flex items-start gap-2 text-slate-400">
                            <svg class="w-4 h-4 mt-0.5 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $siteSettings->get('contacts.address_' . app()->getLocale()) }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
            <div class="flex items-center gap-5 text-sm text-slate-500">
                <a href="{{ locale_path('/privacy') }}" class="hover:text-slate-300 transition-colors">{{ __('Privacy Policy') }}</a>
            </div>
        </div>
    </div>
</footer>
