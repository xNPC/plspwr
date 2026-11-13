<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

/**
 * Serves a dynamic /robots.txt so disallow rules and the sitemap URLs stay in
 * sync with the configure locale domains.
 */
class RobotsController extends Controller
{
    public function index()
    {
        // While the site is under construction (config/seo.php "indexable"
        // is false) disallow every crawler and do not advertise the sitemaps.
        if (! config('seo.indexable', false)) {
            return Response::make("User-agent: *\nDisallow: /\n", 200, [
                'Content-Type' => 'text/plain; charset=utf-8',
                'X-Robots-Tag' => 'noindex, nofollow',
            ]);
        }

        $default = config('locale.default', 'ru');
        $domains = config('locale.domains', []);
        $scheme = config('locale.scheme', 'https');

        $ruDomain = $domains['ru'] ?? $domains[$default] ?? '';
        $enDomain = $domains['en'] ?? '';

        $lines = [
            'User-agent: *',
            'Disallow: /admin/',
            'Disallow: /storage/',
            '',
        ];

        $sitemaps = [];
        if ($ruDomain) {
            $sitemaps[] = $scheme.'://'.$ruDomain.'/sitemap.xml';
        }
        if ($enDomain && $enDomain !== $ruDomain) {
            $sitemaps[] = $scheme.'://'.$enDomain.'/sitemap.xml';
        }

        foreach ($sitemaps as $sitemap) {
            $lines[] = 'Sitemap: '.$sitemap;
        }

        $content = implode("\n", $lines) . "\n";

        return Response::make($content, 200, ['Content-Type' => 'text/plain; charset=utf-8']);
    }
}
