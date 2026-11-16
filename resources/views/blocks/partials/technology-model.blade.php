@php
    $title = $title ?? null;
    $poster = $poster ?? null;
@endphp

<div data-model-container class="relative aspect-[4/3] overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-ink-800 to-ink-900 shadow-2xl shadow-accent-500/10">
    <div class="pointer-events-none absolute inset-0 bg-grid opacity-40"></div>
    <div class="pointer-events-none absolute inset-0 bg-radial-fade"></div>

    @if ($poster)
        <img src="{{ $poster }}" alt="{{ $title }}" data-model-poster
             class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-60 transition-opacity duration-700">
    @endif

    <canvas id="technology-model"
            class="relative z-10 h-full w-full cursor-grab touch-pan-y active:cursor-grabbing"
            data-model="{{ asset('models/technology-model.bin') }}"
            data-loading="{{ __('Loading 3D model…') }}"
            data-error="{{ __('Unable to load the 3D model') }}"
            data-webgl-error="{{ __('WebGL is not available in this browser') }}"
            role="img"
            aria-label="{{ __('Interactive 3D model') }}"></canvas>

    <div data-model-status
         class="pointer-events-none absolute inset-0 z-20 flex items-center justify-center px-6 text-center text-[11px] font-semibold uppercase tracking-[0.2em] text-accent-300 transition-opacity duration-500">
        {{ __('Loading 3D model…') }}
    </div>
</div>

<div class="mt-4 flex items-center justify-center gap-2 text-[11px] uppercase tracking-widest text-slate-400">
    <span class="relative flex h-2 w-2">
        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-accent-400 opacity-75"></span>
        <span class="relative inline-flex h-2 w-2 rounded-full bg-accent-400"></span>
    </span>
    {{ __('Drag to rotate') }}
</div>
