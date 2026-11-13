<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{

    public function run(): void
    {
        $page = Page::firstOrCreate(
            ['is_home' => true],
            [
                'title_ru' => 'НПП «Импульсные технологии» — высоковольтные импульсные модуляторы',
                'title_en' => 'Impulse Technologies — High-Voltage Pulse Modulators',
                'slug_ru' => null,
                'slug_en' => null,
                'is_active' => true,
                'is_home' => true,
                'template' => 'default',
            ]
        );

        // Preserve home blocks/content edited in admin: seed only when empty.
        if ($page->blocks()->exists()) {
            return;
        }

        $images = [
            'intro' => '/storage/img/40_years.jpg',
            'technology' => '/storage/img/solid-state.jpg',
        ];

        $blocks = [
            ['type' => 'hero', 'sort' => 10, 'content' => [
                'ru' => [
                    'title' => 'Импульсная энергетика',
                    'subtitle' => 'Системы впереди времени',
                    'text' => 'Более 40 лет в импульсной энергетике. Надежные технологии. Новейшие разработки. Опыт реализации сложнейших проектов для ключевых отраслей по всему миру.',
                    'badge' => 'НПП Импульсные технологии',
                    'primary_label' => 'Наши разработки',
                    'primary_url' => '/products',
                    'secondary_label' => 'Контакты',
                    'secondary_url' => '/contacts',
                ],
                'en' => [
                    'title' => 'Pulsed Power',
                    'subtitle' => 'Systems ahead of their time',
                    'text' => '40+ years in pulsed power. Reliable technologies. Cutting-edge developments. Proven experience delivering the most demanding projects for key industries worldwide.',
                    'badge' => 'IMPTECH Scientific & Production Enterprise',
                    'primary_label' => 'Our products',
                    'primary_url' => '/en/products',
                    'secondary_label' => 'Contacts',
                    'secondary_url' => '/en/contacts',
                ],
            ]],
            ['type' => 'intro', 'sort' => 20, 'content' => [
                'ru' => [
                    'eyebrow' => 'О компании',
                    'title' => 'Более 40 лет в импульсной энергетике',
                    'text' => '<p>Надежные технологии. Новейшие разработки. Опыт реализации сложнейших проектов для ключевых отраслей по всему миру.</p><p>Продукты под конкретные задачи с полным циклом испытаний и гарантией стабильности параметров на всем протяжении срока эксплуатации.</p>',
                    'link_label' => 'Технология',
                    'link_url' => '/technology',
                    'link2_label' => 'О компании',
                    'link2_url' => '/about',
                ],
                'en' => [
                    'eyebrow' => 'About us',
                    'title' => '40+ years in pulsed power',
                    'text' => '<p>Reliable technologies. Cutting-edge developments. Proven experience with the most demanding projects for key industries worldwide.</p><p>Products tailored to your needs, with full-cycle testing and guaranteed parameter stability throughout their service life.</p>',
                    'link_label' => 'Technology',
                    'link_url' => '/en/technology',
                    'link2_label' => 'About',
                    'link2_url' => '/en/about',
                ],
            ]],
            ['type' => 'products', 'sort' => 30, 'content' => [
                'ru' => [
                    'eyebrow' => 'Продукция',
                    'title' => 'Изготавливаемое оборудование',
                    'description' => 'Высоковольтные импульсные модуляторы и системы импульсной энергетики полного цикла.',
                ],
                'en' => [
                    'eyebrow' => 'Products',
                    'title' => 'Equipment we make',
                    'description' => 'High-voltage pulse modulators and full-cycle pulsed power systems.',
                ],
            ]],
            ['type' => 'applications', 'sort' => 40, 'content' => [
                'ru' => [
                    'eyebrow' => 'Применения',
                    'title' => 'Области применения',
                    'description' => 'Наши решения работают там, где проверяют каждую деталь.',
                ],
                'en' => [
                    'eyebrow' => 'Applications',
                    'title' => 'Areas of application',
                    'description' => 'Our solutions work where every detail is scrutinised.',
                ],
            ]],
            ['type' => 'stats', 'sort' => 50, 'content' => [
                'ru' => [
                    'eyebrow' => 'Опыт',
                    'title' => 'Наш опыт в цифрах',
                    'stats' => [
                        ['value' => 3500, 'label' => 'Поставлено систем'],
                        ['value' => 190, 'label' => 'Заказов'],
                        ['value' => 47, 'label' => 'Стран'],
                        ['value' => 4071000, 'label' => 'Часов эксплуатации'],
                    ],
                ],
                'en' => [
                    'eyebrow' => 'Experience',
                    'title' => 'Our track record',
                    'stats' => [
                        ['value' => 3500, 'label' => 'Systems delivered'],
                        ['value' => 190, 'label' => 'Orders'],
                        ['value' => 47, 'label' => 'Countries'],
                        ['value' => 4071000, 'label' => 'Operation hours'],
                    ],
                ],
            ]],
            ['type' => 'technology', 'sort' => 60, 'content' => [
                'ru' => [
                    'eyebrow' => 'Технология',
                    'title' => 'Лидерство в области твердотельных технологий',
                    'text' => '<p>Компания ИМПТЕХ находится в Западной Сибири, в Томске — академическом городе, исторически пропитанном наукой. Продолжаем традиции, проектируем и производим оборудование независимо — от идеи до готового результата.</p>',
                    'link_label' => 'Технология',
                    'link_url' => '/technology',
                    'link2_label' => 'О компании',
                    'link2_url' => '/about',
                    'points' => [
                        'Проектирование и производство независимо — от идеи до результата',
                        'Собственная компонентная база и технологические решения',
                        'Уникальные продукты и техподдержка',
                        'Работает стабильно и предсказуемо годами',
                    ],
                ],
                'en' => [
                    'eyebrow' => 'Technology',
                    'title' => 'Leadership in solid-state technology',
                    'text' => '<p>IMPTECH is based in Western Siberia, in Tomsk — an academic city steeped in science. We continue the tradition and design and build equipment independently, from idea to finished result.</p>',
                    'link_label' => 'Technology',
                    'link_url' => '/en/technology',
                    'link2_label' => 'About',
                    'link2_url' => '/en/about',
                    'points' => [
                        'Independent design and manufacturing, from idea to result',
                        'Own component base and technology solutions',
                        'Unique products and technical support',
                        'Runs reliably and predictably for years',
                    ],
                ],
            ]],
            ['type' => 'cases', 'sort' => 70, 'content' => [
                'ru' => [
                    'eyebrow' => 'Кейсы',
                    'title' => 'Наши кейсы',
                    'description' => 'Импульсная энергия для радиохирургии, науки и промышленности.',
                ],
                'en' => [
                    'eyebrow' => 'Case studies',
                    'title' => 'Our case studies',
                    'description' => 'Pulsed power for radiosurgery, science and industry.',
                ],
            ]],
            ['type' => 'news', 'sort' => 80, 'content' => [
                'ru' => [
                    'eyebrow' => 'Медиа',
                    'title' => 'Новости',
                ],
                'en' => [
                    'eyebrow' => 'Media',
                    'title' => 'News',
                ],
            ]],
            ['type' => 'cta', 'sort' => 90, 'content' => [
                'ru' => [
                    'title' => 'Технологии на результат. Всегда рядом.',
                    'text' => 'Работайте с нами — от идеи до серийного производства.',
                    'primary_label' => 'Работайте с нами',
                    'primary_url' => '/contacts',
                    'secondary_label' => 'Контакты',
                    'secondary_url' => '/contacts',
                ],
                'en' => [
                    'title' => 'Technology for results. Always by your side.',
                    'text' => 'Work with us — from idea to serial production.',
                    'primary_label' => 'Work with us',
                    'primary_url' => '/en/contacts',
                    'secondary_label' => 'Contacts',
                    'secondary_url' => '/en/contacts',
                ],
            ]],
        ];

        foreach ($blocks as $data) {
            $page->blocks()->create($this->withBlockImage($data, $images));
        }
    }
}