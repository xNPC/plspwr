<div class="relative rounded-2xl border border-white/10 bg-ink-900/70 backdrop-blur p-8 shadow-xl shadow-accent-500/5">
    @if ($sent)
        <div class="text-center py-10">
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-accent-500/20 to-glow-500/20 border border-accent-500/30">
                <svg class="h-8 w-8 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="font-display text-xl font-semibold text-white mb-2">{{ __('Thank you!') }}</h3>
            <p class="text-slate-400">{{ __('Your message has been sent. We will get back to you shortly.') }}</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-lead-input label="{{ __('Name') }}" model="name" required />
                <x-lead-input label="{{ __('Company') }}" model="company" />
                <x-lead-input label="{{ __('Email') }}" model="email" type="email" />
                <x-lead-input label="{{ __('Phone') }}" model="phone" type="tel" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">{{ __('Subject') }}</label>
                <input type="text" wire:model="subject"
                       class="w-full rounded-lg border border-white/10 bg-ink-950/60 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 outline-none transition-colors"
                       placeholder="{{ __('How can we help?') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">{{ __('Message') }} <span class="text-accent-400">*</span></label>
                <textarea wire:model="message" rows="4" required
                          class="w-full rounded-lg border border-white/10 bg-ink-950/60 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 outline-none transition-colors resize-y"
                          placeholder="{{ __('Your message...') }}"></textarea>
                @error('message') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-start gap-3 text-sm text-slate-400 cursor-pointer">
                <input type="checkbox" wire:model="consent" required class="mt-0.5 h-4 w-4 rounded border-white/20 bg-ink-950 text-accent-500 focus:ring-accent-500">
                <span>
                    {{ __('By submitting you agree to the') }}
                    <a href="{{ locale_path('/privacy') }}" class="text-accent-400 hover:text-accent-300 underline">{{ __('privacy policy') }}</a>.
                </span>
            </label>
            @error('consent') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror

            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-accent-500 to-glow-500 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-accent-500/25 hover:brightness-110 disabled:opacity-60 transition-all"
                    wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading wire:target="submit" class="inline-block h-4 w-4 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                <span wire:ignore>{{ __('Send message') }}</span>
            </button>
        </form>
    @endif
</div>
