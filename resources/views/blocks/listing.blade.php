@php
    $renderer = app(\App\Services\BlockRenderer::class);
    $listingBlocks = $page?->blocks()->where('is_active', true)->orderBy('sort')->get() ?? collect();
    $shared = [
        'products' => $families ?? $products ?? collect(),
        'applications' => $applications ?? collect(),
        'cases' => $cases ?? collect(),
        'posts' => $posts ?? collect(),
    ];
@endphp

@foreach ($listingBlocks as $block)
    {!! $renderer->render($block, $shared) !!}
@endforeach