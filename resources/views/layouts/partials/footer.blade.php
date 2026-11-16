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

                    @php
                        $footerMessengers = array_values(array_filter([
                            ['url' => $siteSettings->get('contacts.telegram'), 'label' => 'Telegram', 'icon' => 'telegram'],
                            ['url' => $siteSettings->get('contacts.whatsapp'), 'label' => 'WhatsApp', 'icon' => 'whatsapp'],
                            ['url' => $siteSettings->get('contacts.max'), 'label' => 'Max', 'icon' => 'max'],
                        ], static fn (array $item) => filled($item['url'])));
                    @endphp

                    @if ($footerMessengers !== [])
                        <li class="flex items-center gap-2 pt-1">
                            @foreach ($footerMessengers as $messenger)
                                <a href="{{ $messenger['url'] }}" target="_blank" rel="noopener noreferrer"
                                   title="{{ $messenger['label'] }}" aria-label="{{ $messenger['label'] }}"
                                   class="flex h-8 w-8 items-center justify-center rounded-lg border border-white/10 bg-ink-950/60 text-slate-300 hover:border-accent-500/40 hover:text-accent-300 transition-colors">
                                    @if ($messenger['icon'] === 'telegram')
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.94 4.6 18.9 19a1.2 1.2 0 0 1-1.94.65l-4.8-3.55-2.31 2.22c-.26.26-.48.48-.98.48l.35-4.9 8.9-8.05c.39-.35-.08-.54-.6-.2L6.5 12.3 1.9 10.86c-1-.31-1.02-1 .21-1.48L20.6 2.3c.83-.3 1.56.2 1.34 2.3z"/></svg>
                                    @elseif ($messenger['icon'] === 'whatsapp')
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.347-.347.52-.52.174-.174.232-.298.347-.497.116-.198.058-.371-.03-.52-.087-.148-.669-1.611-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                    @else
                                        <span class="text-[11px] font-bold leading-none">M</span>
                                    @endif
                                </a>
                            @endforeach
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
