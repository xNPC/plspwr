@php
    $renderer = app(\App\Services\BlockRenderer::class);
@endphp

<x-layouts.app>
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
</x-app-layout>
