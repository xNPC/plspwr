<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menu = Menu::firstOrCreate(
            ['slug' => 'main'],
            ['name' => 'Main navigation']
        );

        // Preserve menu structure edited in admin: seed only when empty.
        if ($menu->items()->exists()) {
            return;
        }

        $items = [
            ['label_ru' => 'Главная', 'label_en' => 'Home', 'type' => 'link', 'url' => '/', 'sort' => 10],
            ['label_ru' => 'Продукция', 'label_en' => 'Products', 'type' => 'link', 'url' => '/products', 'sort' => 20, 'children' => [
                ['label_ru' => 'Модуляторы магнетрона', 'label_en' => 'Magnetron Modulators', 'type' => 'link', 'url' => '/products/m-series'],
                ['label_ru' => 'Модуляторы клистрона', 'label_en' => 'Klystron RF Units', 'type' => 'link', 'url' => '/products/k-series'],
                ['label_ru' => 'Модуляторы E-Gun', 'label_en' => 'E-Gun Modulators', 'type' => 'link', 'url' => '/products/e-series'],
                ['label_ru' => 'Импульсные генераторы', 'label_en' => 'Pulse Generators', 'type' => 'link', 'url' => '/products/pg-series'],
            ]],
            ['label_ru' => 'Применение', 'label_en' => 'Applications', 'type' => 'link', 'url' => '/applications', 'sort' => 30, 'children' => [
                ['label_ru' => 'Медицина', 'label_en' => 'Medtech', 'type' => 'link', 'url' => '/applications/medtech'],
                ['label_ru' => 'Промышленность', 'label_en' => 'Industry', 'type' => 'link', 'url' => '/applications/industry'],
                ['label_ru' => 'Наука', 'label_en' => 'Science', 'type' => 'link', 'url' => '/applications/science'],
                ['label_ru' => 'Безопасность', 'label_en' => 'Security', 'type' => 'link', 'url' => '/applications/security'],
            ]],
            ['label_ru' => 'Технология', 'label_en' => 'Technology', 'type' => 'link', 'url' => '/technology', 'sort' => 40],
            ['label_ru' => 'Кейсы', 'label_en' => 'Cases', 'type' => 'link', 'url' => '/cases', 'sort' => 50],
            ['label_ru' => 'О нас', 'label_en' => 'About', 'type' => 'link', 'url' => '/about', 'sort' => 60, 'children' => [
                ['label_ru' => 'Новости', 'label_en' => 'News', 'type' => 'link', 'url' => '/news'],
                ['label_ru' => 'События', 'label_en' => 'Events', 'type' => 'link', 'url' => '/events'],
                ['label_ru' => 'История', 'label_en' => 'History', 'type' => 'link', 'url' => '/history'],
                ['label_ru' => 'Команда', 'label_en' => 'Our team', 'type' => 'link', 'url' => '/team'],
            ]],
            ['label_ru' => 'Контакты', 'label_en' => 'Contacts', 'type' => 'link', 'url' => '/contacts', 'sort' => 70],
        ];

        foreach ($items as $data) {
            $children = $data['children'] ?? [];
            unset($data['children']);

            $parent = $menu->items()->create($data);

            foreach ($children as $childData) {
                $childData['menu_id'] = $menu->id;
                $childData['parent_id'] = $parent->id;
                $parent->children()->create($childData + ['menu_id' => $menu->id]);
            }
        }
    }
}
