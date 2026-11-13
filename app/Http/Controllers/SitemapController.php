<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CaseStudy;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductFamily;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;

/**
 * Generates the base /sitemap.xml (single, bilingual via xhtml:link alternates).
 */
class SitemapController extends Controller
{
    public function index()
    {
        $entries = new Collection();

        $this->addListings($entries);
        $this->addPages($entries);
        $this->addFamilies($entries);
        $this->addProducts($entries);
        $this->addApplications($entries);
        $this->addCases($entries);
        $this->addPosts($entries);

        $entries = $entries
            ->filter(fn (array $e) => ($e['ru'] ?? null) !== null)
            ->values();

        $xml = $this->buildXml($entries);

        return Response::make($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }

    private function buildXml(Collection $entries): string
    {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement('urlset');
        $writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $writer->writeAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');
        $writer->setIndent(true);
        $writer->setIndentString('  ');

        foreach ($entries as $entry) {
            $ruPath = $entry['ru'];
            $enPath = $entry['en'];
            $ruUrl = absolute_url_for_locale($ruPath, 'ru');
            $enUrl = $enPath ? absolute_url_for_locale($enPath, 'en') : null;

            $writer->startElement('url');
            $writer->writeElement('loc', $ruUrl);
            $writer->writeElement('lastmod', $entry['lastmod']);
            $writer->writeElement('changefreq', $entry['changefreq']);
            $writer->writeElement('priority', (string) $entry['priority']);

            // hreflang ru
            $writer->startElement('xhtml:link');
            $writer->writeAttribute('rel', 'alternate');
            $writer->writeAttribute('hreflang', 'ru');
            $writer->writeAttribute('href', $ruUrl);
            $writer->endElement();

            // hreflang en (only if en path exists)
            if ($enUrl) {
                $writer->startElement('xhtml:link');
                $writer->writeAttribute('rel', 'alternate');
                $writer->writeAttribute('hreflang', 'en');
                $writer->writeAttribute('href', $enUrl);
                $writer->endElement();
            }

            // x-default → ru
            $writer->startElement('xhtml:link');
            $writer->writeAttribute('rel', 'alternate');
            $writer->writeAttribute('hreflang', 'x-default');
            $writer->writeAttribute('href', $ruUrl);
            $writer->endElement();

            $writer->endElement(); // url
        }

        $writer->endElement(); // urlset
        $writer->endDocument();

        return $writer->outputMemory();
    }

    /**
     * Static listing pages rendered by the index() controllers.
     */
    private function addListings(Collection $entries): void
    {
        // Home page
        $entries->push([
            'ru' => '/',
            'en' => '/',
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => 1.0,
        ]);

        $routeToPost = [
            '/products' => 'ProductController@index',
            '/applications' => 'ApplicationController@index',
            '/cases' => 'CaseStudyController@index',
            '/contacts' => 'ContactController@index',
            '/news' => 'NewsController@index',
        ];

        foreach ($routeToPost as $path => $hold) {
            $entries->push([
                'ru' => $path,
                'en' => $path,
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => 0.8,
            ]);
        }

        $hasEvents = Post::query()
            ->where('category', 'event')
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->exists();

        if ($hasEvents) {
            $entries->push([
                'ru' => '/events',
                'en' => '/events',
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => 0.7,
            ]);
        }
    }

    private function addPages(Collection $entries): void
    {
        Page::query()
            ->with('seo')
            ->where('is_active', true)
            ->get()
            ->each(function (Page $page) use ($entries) {
                if ($page->is_home) {
                    return;
                }

                $ru = $page->slug_ru ?? $page->slug_en;
                if (! $ru) {
                    return;
                }
                $en = $page->slug_en ?? null;

                $this->push($entries, $this->path('/'.$ru), $en ? $this->path('/'.$en) : null, $page, 0.8, 'weekly');
            });
    }

    private function addFamilies(Collection $entries): void
    {
        ProductFamily::query()
            ->with('seo')
            ->where('is_active', true)
            ->get()
            ->each(function (ProductFamily $family) use ($entries) {
                $ru = $family->slug_ru ?? $family->slug_en;
                $en = $family->slug_en ?? null;

                $this->push($entries, $this->path('products/'.$ru), $en ? $this->path('products/'.$en) : null, $family, 0.8, 'weekly');
            });
    }

    private function addProducts(Collection $entries): void
    {
        Product::query()
            ->with(['family', 'seo'])
            ->where('is_active', true)
            ->get()
            ->each(function (Product $product) use ($entries) {
                $familyRu = $product->family?->slug_ru ?? $product->family?->slug_en;
                $productRu = $product->slug_ru ?? $product->slug_en;

                if (! $familyRu || ! $productRu) {
                    return;
                }

                $pathRu = "products/{$familyRu}/{$productRu}";

                $familyEn = $product->family?->slug_en ?? $product->family?->slug_ru;
                $productEn = $product->slug_en ?? null;

                $pathEn = $familyEn && $productEn
                    ? "products/{$familyEn}/{$productEn}"
                    : null;

                $this->push($entries, $this->path($pathRu), $pathEn ? $this->path($pathEn) : null, $product, 0.7, 'monthly');
            });
    }

    private function addApplications(Collection $entries): void
    {
        Application::query()
            ->with('seo')
            ->where('is_active', true)
            ->get()
            ->each(function (Application $application) use ($entries) {
                $ru = $application->slug_ru ?? $application->slug_en;
                $en = $application->slug_en ?? null;

                $this->push($entries, $this->path('applications/'.$ru), $en ? $this->path('applications/'.$en) : null, $application, 0.7, 'monthly');
            });
    }

    private function addCases(Collection $entries): void
    {
        CaseStudy::query()
            ->with('seo')
            ->where('is_active', true)
            ->get()
            ->each(function (CaseStudy $case) use ($entries) {
                $ru = $case->slug_ru ?? $case->slug_en;
                $en = $case->slug_en ?? null;

                $this->push($entries, $this->path('cases/'.$ru), $en ? $this->path('cases/'.$en) : null, $case, 0.7, 'monthly');
            });
    }

    private function addPosts(Collection $entries): void
    {
        Post::query()
            ->with('seo')
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->get()
            ->each(function (Post $post) use ($entries) {
                $prefix = $post->category === 'event' ? 'events' : 'news';
                $ru = $post->slug_ru ?? $post->slug_en;
                $en = $post->slug_en ?? null;

                $this->push($entries, $this->path($prefix.'/'.$ru), $en ? $this->path($prefix.'/'.$en) : null, $post, 0.6, 'monthly');
            });
    }

    /**
     * Normalise a path so it starts with a single leading slash.
     */
    private function path(string $path): string
    {
        $path = trim($path);
        if ($path === '') {
            return '/';
        }

        return '/'.ltrim($path, '/');
    }

    /**
     * Push an entry, skipping models flagged noindex.
     */
    private function push(Collection $entries, string $ru, ?string $en, $model, float $priority, string $changefreq): void
    {
        if ($model->seo && $model->seo->noindex) {
            return;
        }

        $entries->push([
            'ru' => $ru,
            'en' => $en,
            'lastmod' => $model->updated_at?->format('Y-m-d') ?? now()->format('Y-m-d'),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ]);
    }
}