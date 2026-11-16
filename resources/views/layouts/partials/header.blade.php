@props([
    'menuItems' => [],
    'title' => null,
])

@php
    $currentPath = '/' . trim(request()->path(), '/');
    // On the home page a large hero logo is shown below the menu, so the
    // small header logo starts hidden (and JS reveals it after scrolling).
    $hideMenuLogo = request()->route()?->named('home') && $siteSettings->image('brand.logo');
@endphp

<header class="fixed top-0 inset-x-0 z-40 border-b border-white/5 transition-colors duration-300" id="site-header">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-[var(--header-height)] items-center justify-between gap-6">
            {{-- Logo --}}
            <a href="{{ localized_route('home') }}" id="header-logo"
               class="flex items-center gap-3 group shrink-0 transition-opacity duration-500 motion-reduce:transition-none {{ $hideMenuLogo ? 'opacity-0 invisible' : 'opacity-100' }}">
                @if ($siteSettings->image('brand.logo'))
                    <img src="{{ $siteSettings->image('brand.logo') }}" alt="{{ config('app.name') }}"
                         class="h-12 w-auto">
                @else
                    <span class="relative flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-accent-500 to-glow-500 text-sm font-bold text-white shadow-lg shadow-accent-500/30">
                        <span class="absolute inset-0 rounded-lg bg-accent-500/40 blur-md group-hover:blur-lg transition"></span>
                        <span class="relative">IT</span>
                    </span>
                    <span class="hidden sm:block font-display font-semibold text-slate-100 leading-tight">
                        <span class="block">{{ __('Impulse') }}</span>
                        <span class="block text-xs font-normal text-slate-400">{{ __('Technologies') }}</span>
                    </span>
                @endif
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden lg:flex items-center gap-1" aria-label="{{ __('Main navigation') }}">
                @foreach ($menuItems as $item)
                    @php
                        $children = $item->children->where('is_active', true);
                        $itemPath = parse_url($item->url ?? '#', PHP_URL_PATH) ?? '#';
                        $isActive = $currentPath !== '/' && trim($itemPath, '/') === trim($currentPath, '/');
                    @endphp
                    @if ($children->isNotEmpty())
                        <div class="relative group">
                            <button type="button" class="nav-link inline-flex items-center gap-1 px-4 py-2 text-sm text-slate-300 hover:text-white transition-colors {{ $isActive ? 'text-white' : '' }}">
                                {{ $item->label }}
                                <svg class="w-3 h-3 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute left-0 top-full pt-2 opacity-0 invisible translate-y-1 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200">
                                <div class="glass rounded-xl p-2 min-w-[220px]">
                                    @foreach ($children as $child)
                                        @php
                                            $childPath = parse_url($child->url ?? '#', PHP_URL_PATH) ?? '#';
                                            $childActive = trim($childPath, '/') === trim($currentPath, '/') && !empty($childPath);
                                        @endphp
                                        <a href="{{ $child->url ?? '#' }}" class="block rounded-lg px-3 py-2 text-sm {{ $childActive ? 'text-accent-300 bg-white/5' : 'text-slate-300' }} hover:text-white hover:bg-white/5 transition-colors">
                                            {{ $child->label }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ $item->url ?? '#' }}" class="px-4 py-2 text-sm {{ $isActive ? 'text-white' : 'text-slate-300' }} hover:text-white transition-colors">
                            {{ $item->label }}
                        </a>
                    @endif
                @endforeach
            </nav>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">
                <a href="{{ locale_path('/contacts') }}"
                   class="hidden md:inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-accent-500 to-glow-500 px-4 py-2 text-sm font-medium text-white shadow-lg shadow-accent-500/25 hover:shadow-accent-500/40 hover:brightness-110 transition-all">
                    {{ __('Contact us') }}
                </a>

                {{-- Language switcher --}}
                @php
                    $currentLocale = $currentLocale ?? app()->getLocale();
                    $altLocale = config('locale.available.' . ($currentLocale === 'ru' ? 'en' : 'ru'))
                        ? ($currentLocale === 'ru' ? 'en' : 'ru')
                        : null;
                @endphp
                @if ($altLocale)
                    <a href="{{ locale_alternate($altLocale) }}"
                       class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-sm font-semibold uppercase text-slate-300 hover:bg-white/5 transition-colors"
                       aria-label="{{ __('Switch to :locale', ['locale' => __($altLocale)]) }}">
                        {{ strtoupper($altLocale) }}
                    </a>
                @endif

                {{-- Mobile menu button --}}
                <button type="button" id="mobile-menu-btn"
                        class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-300 hover:bg-white/5 transition-colors"
                        aria-label="{{ __('Menu') }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

{{-- Mobile menu overlay --}}
<div id="mobile-menu" class="fixed inset-0 z-50 invisible opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-ink-950/80 backdrop-blur-sm" id="mobile-menu-backdrop"></div>
    <div class="absolute right-0 top-0 h-full w-80 max-w-[85vw] bg-ink-900 border-l border-white/10 p-6 overflow-y-auto translate-x-full transition-transform duration-300 ease-out">
        <div class="flex justify-end mb-6">
            <button type="button" id="mobile-menu-close" class="text-slate-400 hover:text-white transition-colors" aria-label="{{ __('Close') }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="space-y-1" aria-label="{{ __('Mobile navigation') }}">
            @foreach ($menuItems as $item)
                @php
                    $children = $item->children->where('is_active', true);
                    $itemPath = parse_url($item->url ?? '#', PHP_URL_PATH) ?? '#';
                    $isActive = $currentPath !== '/' && trim($itemPath, '/') === trim($currentPath, '/');
                @endphp
                @if ($children->isNotEmpty())
                    <div class="mb-2">
                        <div class="text-sm font-semibold text-white mb-1">{{ $item->label }}</div>
                        <div class="pl-3 space-y-1 border-l border-white/10">
                            @foreach ($children as $child)
                                @php $childPath = parse_url($child->url ?? '#', PHP_URL_PATH) ?? '#'; @endphp
                                <a href="{{ $child->url ?? '#' }}" class="block py-1.5 text-sm {{ trim($childPath, '/') === trim($currentPath, '/') ? 'text-accent-300' : 'text-slate-300' }} hover:text-white">{{ $child->label }}</a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $item->url ?? '#' }}" class="block py-2 text-sm {{ $isActive ? 'text-accent-300' : 'text-slate-300' }} hover:text-white transition-colors">{{ $item->label }}</a>
                @endif
            @endforeach
        </nav>
    </div>
</div>
