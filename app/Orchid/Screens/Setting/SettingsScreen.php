<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Setting;

use App\Models\Setting;
use App\Orchid\Layouts\Setting\SettingEditLayout;
use App\Services\LeadNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SettingsScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'settings' => [
                'brand' => [
                    'tagline_ru' => Setting::get('brand.tagline_ru', ''),
                    'tagline_en' => Setting::get('brand.tagline_en', ''),
                ],
                'contacts' => [
                    'phone' => Setting::get('contacts.phone', ''),
                    'email' => Setting::get('contacts.email', ''),
                    'address_ru' => Setting::get('contacts.address_ru', ''),
                    'address_en' => Setting::get('contacts.address_en', ''),
                    'work_hours_ru' => Setting::get('contacts.work_hours_ru', ''),
                    'work_hours_en' => Setting::get('contacts.work_hours_en', ''),
                    'telegram' => Setting::get('contacts.telegram', ''),
                    'whatsapp' => Setting::get('contacts.whatsapp', ''),
                    'max' => Setting::get('contacts.max', ''),
                ],
                'leads' => [
                    'notify_emails' => Setting::get('leads.notify_emails', ''),
                ],
            ],
        ];
    }

    public function name(): ?string
    {
        return __('Site Settings');
    }

    public function description(): ?string
    {
        return __('Manage site-wide settings used by the public site.');
    }

    public function permission(): ?iterable
    {
        return ['platform.content.settings'];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::block(SettingEditLayout::class)
                ->title(__('Settings'))
                ->description(__('These values are displayed across the public site.')),
        ];
    }

    public function save(Request $request): RedirectResponse
    {
        foreach ($request->input('settings', []) as $group => $items) {
            foreach ((array) $items as $key => $value) {
                Setting::set($group.'.'.$key, $value);
            }
        }

        $this->normalizeNotifyEmails((string) $request->input('settings.leads.notify_emails', ''));

        Toast::info(__('Settings were saved.'));

        return redirect()->route('platform.content.settings');
    }

    /**
     * Сохранить список получателей заявок в нормализованном виде
     * и предупредить о некорректных адресах.
     */
    private function normalizeNotifyEmails(string $raw): void
    {
        $valid = LeadNotifier::parseEmails($raw);

        Setting::set('leads.notify_emails', implode(', ', $valid));

        $parts = preg_split('/[\s,;]+/', $raw, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $invalid = array_values(array_filter(
            $parts,
            static fn (string $part) => ! filter_var(trim($part), FILTER_VALIDATE_EMAIL)
        ));

        if ($invalid !== []) {
            Toast::warning('Некорректные адреса пропущены: '.implode(', ', $invalid));
        }
    }
}
