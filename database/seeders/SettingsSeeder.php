<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group' => 'brand', 'key' => 'logo', 'value' => '/brand.svg'],
            ['group' => 'brand', 'key' => 'tagline_ru', 'value' => 'Производство высоковольтных импульсных модуляторов и систем импульсной энергетики.'],
            ['group' => 'brand', 'key' => 'tagline_en', 'value' => 'Manufacturer of high-voltage pulsed-power modulators and systems.'],
            ['group' => 'contacts', 'key' => 'phone', 'value' => '+7 (3822) 99 99 99'],
            ['group' => 'contacts', 'key' => 'email', 'value' => 'info@plspwr.ru'],
            ['group' => 'contacts', 'key' => 'address_ru', 'value' => 'г. Томск, пр-кт Развития, д. 3, офис 118'],
            ['group' => 'contacts', 'key' => 'address_en', 'value' => '3 Razvitiya Ave., office 118, Tomsk, Russia'],
            ['group' => 'contacts', 'key' => 'work_hours_ru', 'value' => 'пн-пт: с 08:30 до 17:30'],
            ['group' => 'contacts', 'key' => 'work_hours_en', 'value' => 'Mon–Fri: 08:30 – 17:30'],
        ];

        foreach ($settings as $item) {
            // Preserve values edited in admin: seed only missing keys.
            Setting::firstOrCreate(
                ['group' => $item['group'], 'key' => $item['key']],
                ['value' => $item['value']]
            );
        }
    }
}
