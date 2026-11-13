<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

if (! function_exists('locale_path')) {
    /**
     * Build a locale-aware internal path/URL.
     *
     * In host-based (production) mode each locale lives on its own domain, so the
     * path is returned as-is. In path-based (dev) mode a non-default locale is
     * prefixed with /{locale} so that links stay within the same language version.
     *
     * Accepts a relative path ("/products"), a named-route absolute URL, or an
     * external absolute URL (returned unchanged).
     */
    function locale_path(string $path): string
    {
        $path = trim($path);

        if ($path === '') {
            return '/';
        }

        $isAbsolute = preg_match('#^https?://#i', $path) === 1;

        if (!$isAbsolute && ! str_starts_with($path, '/')) {
            $path = '/'.$path;
        }

        $locale = app()->getLocale();
        $default = config('locale.default', 'ru');
        $domains = config('locale.domains', []);

        $host = request()->getHost();
        $hostMatchesDomain = false;
        foreach ($domains as $domainLocale => $domain) {
            if ($domain && str_ends_with($host, $domain)) {
                $hostMatchesDomain = true;
                break;
            }
        }

        $needsPrefix = !$hostMatchesDomain && $locale !== $default;

        if (!$needsPrefix) {
            return $path;
        }

        $pathSegment = $isAbsolute ? parse_url($path, PHP_URL_PATH) : $path;
        $pathSegment = $pathSegment === false || $pathSegment === null ? '/' : $pathSegment;

        if (preg_match('#^/'.preg_quote($locale, '#').'(?:/|$)#', $pathSegment)) {
            return $path;
        }

        $prefix = '/'.$locale;

        if (!$isAbsolute) {
            return $prefix.$path;
        }

        // Rebuild absolute URL with the locale segment inserted into the path.
        $scheme = parse_url($path, PHP_URL_SCHEME);
        $user = parse_url($path, PHP_URL_USER);
        $pass = parse_url($path, PHP_URL_PASS);
        $hostP = parse_url($path, PHP_URL_HOST);
        $port = parse_url($path, PHP_URL_PORT);
        $query = parse_url($path, PHP_URL_QUERY);
        $fragment = parse_url($path, PHP_URL_FRAGMENT);

        $authority = '';
        if ($user) {
            $authority .= $user.($pass ? ':'.$pass : '');
        }
        if ($user) {
            $authority .= '@';
        }
        $authority .= $hostP;
        if ($port) {
            $authority .= ':'.$port;
        }

        $newPath = $pathSegment === '/' ? $prefix : $prefix.$pathSegment;

        $rebuilt = $scheme.'://'.$authority.$newPath;
        if ($query) {
            $rebuilt .= '?'.$query;
        }
        if ($fragment) {
            $rebuilt .= '#'.$fragment;
        }

        return $rebuilt;
    }
}

if (! function_exists('localized_route')) {
    /**
     * Build a locale-aware URL from a named route.
     */
    function localized_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        if (! Route::has($name)) {
            return locale_path('/');
        }

        return locale_path(route($name, $parameters, $absolute));
    }
}

if (! function_exists('locale_alternate')) {
    /**
     * Build the URL for a given locale version of the current page.
     *
     * In host-based (production) mode the scheme://host is swapped to the target
     * locale's domain. In path-based (dev) mode the /{locale} prefix is added or
     * removed accordingly.
     */
    function locale_alternate(string $targetLocale): string
    {
        $current = app()->getLocale();
        $default = config('locale.default', 'ru');
        $domains = config('locale.domains', []);
        $path = request()->path();

        // Preserve the original locale prefix when present (dev fallback).
        $segments = request()->segments();
        $first = $segments[0] ?? null;
        $available = config('locale.available', []);

        if ($first !== null && array_key_exists($first, $available)) {
            $path = implode('/', array_slice($segments, 1));
        }

        $host = request()->getHost();
        $hostMatchesDomain = false;
        foreach ($domains as $locale => $domain) {
            if ($domain && str_ends_with($host, $domain)) {
                $hostMatchesDomain = true;
                break;
            }
        }

        // If both current host and target map to real domains: switch the host.
        $currentDomain = $domains[$current] ?? '';
        $targetDomain = $domains[$targetLocale] ?? '';
        if ($hostMatchesDomain && $currentDomain && $targetDomain) {
            $scheme = config('locale.scheme', request()->getScheme());
            $url = $scheme.'://'.$targetDomain;
            $url .= $path === '' || $path === '/' ? '/' : '/'.$path;
            if ($query = request()->getQueryString()) {
                $url .= '?'.$query;
            }

            return $url;
        }

        // Path-based (dev) mode: toggle the locale prefix.
        if ($targetLocale === $default) {
            $urlPath = $path === '' || $path === '/' ? '/' : '/'.$path;
        } else {
            $urlPath = $path === '' || $path === '/' ? '/'.$targetLocale : '/'.$targetLocale.'/'.$path;
        }
        $url = $urlPath;
        if ($query = request()->getQueryString()) {
            $url .= '?'.$query;
        }

        return $url;
    }
}

if (! function_exists('absolute_url_for_locale')) {
    /**
     * Build an absolute URL for a given locale, independent of the current host.
     *
     * Intended for sitemap/robots generation where a deterministic ru/en domain
     * pair is required regardless of the request host (local dev server, etc.).
     *
     * Accepts a path like "/products/m-series/m200". In host-based (production)
     * mode the locale's domain is used; the default locale needs no prefix. In
     * dev (path-based) mode, the configured domain is still applied so the pair
     * stays stable, with a /{locale} prefix for non-default locales when needed.
     */
    function absolute_url_for_locale(string $path, string $locale): string
    {
        $path = trim($path);
        if ($path === '') {
            $path = '/';
        }
        if (! str_starts_with($path, '/')) {
            $path = '/'.$path;
        }

        $default = config('locale.default', 'ru');
        $domains = config('locale.domains', []);
        $domain = $domains[$locale] ?? '';

        if ($domain) {
            // Host-based mode: strip any existing locale prefix so the canonical
            // path is used on the locale's own domain (no /{locale} segment).
            foreach ($domains as $availableLocale => $_) {
                if (preg_match('#^/'.preg_quote($availableLocale, '#').'(?:/|$)#', $path)) {
                    $path = str_starts_with($path, '/'.$availableLocale.'/')
                        ? substr($path, strlen('/'.$availableLocale))
                        : '/';
                    break;
                }
            }
            $scheme = config('locale.scheme', 'https');

            return $scheme.'://'.$domain.$path;
        }

        // No domains configured: fall back to host-based absolute URL.
        $urlPath = $locale === $default ? $path : '/'.$locale.$path;
        $scheme = request()->getScheme();
        $host = config('locale.host', request()->getHost());

        return $scheme.'://'.$host.$urlPath;
    }
}

