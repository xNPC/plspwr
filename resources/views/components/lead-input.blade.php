@props([
    'label' => '',
    'model' => '',
    'type' => 'text',
    'required' => false,
    'placeholder' => null,
])

<div>
    <label for="field-{{ $model }}" class="block text-sm font-medium text-slate-300 mb-1.5">
        {{ $label }}
        @if ($required) <span class="text-accent-400">*</span> @endif
    </label>
    <input
        type="{{ $type }}"
        id="field-{{ $model }}"
        wire:model="{{ $model }}"
        @if ($required) required @endif
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        class="w-full rounded-lg border border-white/10 bg-ink-950/60 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 outline-none transition-colors"
    >
    @error($model) <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
</div>
