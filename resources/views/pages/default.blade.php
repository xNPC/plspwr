@php
    $renderer = app(\App\Services\BlockRenderer::class);
@endphp

<x-layouts.app>
    @include('partials.page-banner', [
        'title' => $page->title,
        'description' => $page->description,
        'image' => $page->banner_image,
        'breadcrumbs' => [
            ['label' => __('Home'), 'url' => localized_route('home')],
            ['label' => $page->title],
        ],
    ])

    @foreach ($content as $block)
        @php
            $shared = [
                'products' => $products ?? collect(),
                'applications' => $applications ?? collect(),
                'cases' => $cases ?? collect(),
                'posts' => $posts ?? collect(),
            ];
        @endphp
        {!! $renderer->render($block, $shared) !!}
    @endforeach
</x-layouts.app>
