<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromDomain
{
    /**
     * Resolve the site locale per-request.
     *
     * Priority:
     *   1. Explicit path prefix /{locale} (dev fallback, e.g. /en). The prefix is
     *      stripped from the request before routing so a single canonical route set
     *      serves every locale; path-mode is flagged for locale-aware URL building.
     *   2. The request host, when it matches a configured locale domain
     *      (production separate domains).
     *   3. The configured default locale.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $available = config('locale.available', ['ru' => 'ru']);
        $fallback = config('locale.default', 'ru');
        $domains = config('locale.domains', []);

        // 1) Path prefix (dev/testing). Only applies when the host is not already
        //    mapped to a locale domain, otherwise URLs like /en/en/... are avoided.
        $host = $request->getHost();
        $hostMatchesDomain = false;
        foreach ($domains as $locale => $domain) {
            if ($domain && str_ends_with($host, $domain)) {
                $hostMatchesDomain = true;
                break;
            }
        }

        $segment = $request->segment(1);

        if (!$hostMatchesDomain && $segment && array_key_exists($segment, $available)) {
            app()->setLocale($segment);
            $this->stripLocalePrefix($request);

            return $next($request);
        }

        // 2) Domain-based detection (production).
        foreach ($domains as $locale => $domain) {
            if ($domain && str_ends_with($host, $domain)) {
                app()->setLocale($locale);

                return $next($request);
            }
        }

        // 3) Fall back to configured default.
        app()->setLocale($fallback);

        return $next($request);
    }

    /**
     * Remove the leading /{locale} segment from the request path so the canonical
     * (plain) route set can match. Global middleware runs before route matching, so
     * mutating the server here is picked up by the router.
     */
    private function stripLocalePrefix(Request $request): void
    {
        $segments = $request->segments();
        array_shift($segments);

        $path = '/'.implode('/', $segments);
        if ($path === '/') {
            $path = '/';
        }

        $query = $request->getQueryString() ? '?'.$request->getQueryString() : '';

        $request->server->set('REQUEST_URI', $path.$query);
        $request->server->set('PATH_INFO', $path ?: '/');
        $request->server->set('ORIGINAL_REQUEST_URI', $request->getRequestUri());

        $request->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $request->getContent(),
        );
    }
}
