@php
    /** @var \App\Services\SeoPresenter $seo */
    $seo = $seo ?? new \App\Services\SeoPresenter(null, ['title' => config('app.name')]);
    $seoTitle = $seo->title();
    $seoDesc = $seo->description();
    $seoKeywords = $seo->keywords();
    $seoCanonical = $seo->canonical();
    $seoNoindex = $seo->noindex();
    $seoRobots = $seo->robots();
    $ogImage = $seo->ogImage();
    $hreflang = [];
    foreach (array_keys(config('locale.available')) as $__locale) {
        $__url = $seo->hreflangUrls()[$__locale] ?? null;
        $hreflang[$__locale] = $__url ?: url(\locale_alternate($__locale));
    }
@endphp

<title>{{ $seoTitle }}</title>
@if ($seoDesc)
    <meta name="description" content="{{ $seoDesc }}">
@endif
@if ($seoKeywords)
    <meta name="keywords" content="{{ $seoKeywords }}">
@endif
<meta name="robots" content="{{ $seoRobots }}">
<link rel="canonical" href="{{ $seoCanonical }}">

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDesc }}">
<meta property="og:url" content="{{ $seoCanonical }}">
@if ($ogImage)
    @php $ogImageUrl = str_starts_with($ogImage, 'http') ? $ogImage : $seo->absoluteUrl($ogImage); @endphp
    <meta property="og:image" content="{{ $ogImageUrl }}">
@endif
<meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDesc }}">

{{-- Hreflang alternates between the RU/EN versions --}}
@foreach ($hreflang as $locale => $url)
    <link rel="alternate" hreflang="{{ $locale }}" href="{{ $url }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ $hreflang[config('locale.default')] ?? url('/') }}">

<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Organization",
    "name": "{{ config('app.name') }}",
    "url": "{{ url('/') }}"
    @if ($siteSettings->get('contacts.email'))
        ,"email": "{{ $siteSettings->get('contacts.email') }}"
    @endif
    @if ($siteSettings->get('contacts.phone'))
        ,"telephone": "{{ $siteSettings->get('contacts.phone') }}"
    @endif
}
</script>
