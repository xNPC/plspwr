<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Application;
use App\Models\CaseStudy;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductFamily;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{

    public function run(): void
    {
        $this->cleanTestRecords();
        $this->seedFamilies();
        $this->seedApplications();
        $this->seedCases();
        $this->seedNews();
        $this->seedPages();
        $this->seedSections();
    }

    private function cleanTestRecords(): void
    {
        ProductFamily::where('slug_ru', 'like', 'test%')->delete();
        Product::where('slug_ru', 'like', 'test%')->delete();
        Product::whereNotIn('product_family_id', ProductFamily::pluck('id'))->delete();
    }

    private function seedFamilies(): void
    {
        $families = [
            [
                'slug_ru' => 'm-series', 'slug_en' => 'm-series', 'code' => 'M-Series',
                'title_ru' => 'Модуляторы магнетрона', 'title_en' => 'Magnetron Modulators',
                'intro_ru' => 'Предназначены для управления широким спектром магнетронов с пиковой мощностью РЧ от 2,5 до 5 МВт.',
                'intro_en' => 'Designed to drive a wide range of magnetrons, delivering 2.5 to 5 MW of RF peak power.',
                'description_ru' => '<p>Твердотельные модуляторы магнетрона M-Series обеспечивают пиковую мощность РЧ от 2,5 до 5 МВт — наивысшую в нашей линейке. Они спроектированы для самых требовательных систем и способны управлять как магнетронами, так и рядом компактных клистронов. Версия M200D поддерживает режимы одиночной и двойной энергии для приложений, где требуется переключение между двумя уровнями энергии.</p>',
                'description_en' => '<p>The M-Series solid-state magnetron modulators deliver 2.5 to 5 MW of RF peak power — the highest in our lineup. Designed for the most demanding system designs, they can drive magnetrons as well as several compact klystron models. The M200D version supports single and dual energy modes for applications requiring switching between two energy levels.</p>',
                'image' => '/storage/import/m-series.svg',
                'sort' => 10,
                'products' => [
                    [
                        'slug_ru' => 'm200-m200d', 'slug_en' => 'm200-m200d', 'code' => 'M200 / M200D',
                        'title_ru' => 'M200 / M200D', 'title_en' => 'M200 / M200D',
                        'intro_ru' => 'Высокомощный твердотельный модулятор магнетрона для систем РЧ от 2,5 до 5 МВт.',
                        'intro_en' => 'High-power solid-state magnetron modulator for RF systems from 2.5 to 5 MW.',
                        'description_ru' => '<p>Модулятор M200 спроектирован как высокомощный импульсный модулятор для самых требовательных систем заказчиков. Он рассчитан на магнетроны в диапазоне от 2,5 до 5 МВт и может также работать с рядом компактных клистронов. Версия M200D доступна в исполнениях с одиночной или двойной энергией и применяется там, где требуется переключение между двумя уровнями энергии.</p><p>Все новые импульсные модуляторы Компании оснащены современной и удобной системой управления для калибровки, диагностики и настройки. Амплитуда, длительность и частота импульсов легко изменяются и визуализируются в дружественном графическом интерфейсе. Платформа обеспечивает непревзойдённую производительность и простоту интеграции, что сделало M200 востребованным выбором для радиолокации и оборонных применений, где требуются сниженные габариты и вес.</p>',
                        'description_en' => '<p>The M200 modulator is designed as a high-power pulse modulator for our customers\' most demanding system designs. It handles magnetrons in the 2.5 to 5 MW range and can also drive several compact klystron models. The M200D version is available with single or dual energy for applications requiring switching between two energy levels.</p><p>All new pulse modulators from the Company are equipped with a modern, user-friendly control system for calibration, diagnostics and adjustment. Amplitude, pulse width and frequency are easily changed and visualised in the intuitive GUI. The platform delivers unparalleled performance and ease of integration, making M200 a compelling choice for radar and defence applications where reduced size and weight are required.</p>',
                        'specifications' => [
                            ['name_ru' => 'Пиковая мощность РЧ', 'value_ru' => '2,5 – 5 МВт', 'name_en' => 'RF peak power', 'value_en' => '2.5 – 5 MW'],
                            ['name_ru' => 'Напряжение импульса', 'value_ru' => '40 – 75 кВ', 'name_en' => 'Pulse voltage', 'value_en' => '40 – 75 kV'],
                            ['name_ru' => 'Ток импульса', 'value_ru' => '30 – 250 А', 'name_en' => 'Pulse current', 'value_en' => '30 – 250 A'],
                            ['name_ru' => 'Пиковая мощность модулятора', 'value_ru' => '14 МВт', 'name_en' => 'Modulator peak', 'value_en' => '14 MW'],
                            ['name_ru' => 'Средняя мощность модулятора', 'value_ru' => '16 кВт', 'name_en' => 'Modulator avg.', 'value_en' => '16 kW'],
                            ['name_ru' => 'Вес (с маслом)', 'value_ru' => 'ок. 200 кг (M200D — 180 кг)', 'name_en' => 'Weight (incl. oil)', 'value_en' => 'approx. 200 kg (M200D — 180 kg)'],
                        ],
                        'gallery' => [
                            '/storage/import/m-series.svg',
                        ],
                        'sort' => 10,
                    ],
                ],
            ],
            [
                'slug_ru' => 'k-series', 'slug_en' => 'k-series', 'code' => 'K-Series',
                'title_ru' => 'Модуляторы клистрона (РЧ-блоки)', 'title_en' => 'Klystron RF Units',
                'intro_ru' => 'РЧ-блоки и модуляторы на основе клистронов с пиковой мощностью РЧ от 3 до 10 МВт.',
                'intro_en' => 'Klystron-based RF units and modulators delivering 3 to 10 MW of RF peak power.',
                'description_ru' => '<p>РЧ-блоки K-Series построены на основе модуляторов клистрона и обеспечивают пиковую мощность РЧ от 3 до 10 МВт. Они спроектированы преимущественно для стационарной эксплуатации в промышленности и науке. Доступны как в виде чистого импульсного модулятора, так и в виде готовой РЧ-системы «под ключ» с различными конфигурациями под конкретные модели клистронов.</p>',
                'description_en' => '<p>The K-Series RF units are built on klystron modulators and deliver 3 to 10 MW of RF peak power. They are designed primarily for stationary operation in industry and science. Available either as a pure pulse modulator or as a turn-key RF system, with configurations to match specific klystron models.</p>',
                'image' => '/storage/import/k-series.svg',
                'sort' => 20,
                'products' => [
                    [
                        'slug_ru' => 'k100', 'slug_en' => 'k100', 'code' => 'K100',
                        'title_ru' => 'K100', 'title_en' => 'K100',
                        'intro_ru' => 'РЧ-блок на основе модулятора клистрона, пиковая мощность 3–10 МВт.',
                        'intro_en' => 'Klystron-based RF unit, 3–10 MW RF peak power.',
                        'description_ru' => '<p>K100 — РЧ-блок на основе модулятора клистрона, обеспечивающий пиковую мощность РЧ в диапазоне от 3 до 10 МВт. Это средне-мощная модель линейки K-Series, предназначенная преимущественно для стационарной эксплуатации. Устройство управляет клистронами с пиковой мощностью от 3 до 10 МВт и может поставляться как в виде чистого модулятора, так и в виде готовой РЧ-системы «под ключ» с различными конфигурациями по частоте и модели клистрона.</p><p>Удобная и универсальная система управления со встроенным регистратором сигналов даёт все возможности для настройки системы с оптимальной производительностью. Интерфейс отображает статус ключевых компонентов, триггеры, блокировки и журнал событий в реальном времени.</p>',
                        'description_en' => '<p>K100 is a klystron-based RF unit delivering 3 to 10 MW of RF peak power. It is the mid-range design of the K-Series, intended primarily for stationary operation. The unit drives klystrons from 3 to 10 MW and can be supplied either as a pure modulator or as a turn-key RF system, with configurations based on klystron frequency and model.</p><p>The user-friendly, versatile control system with integrated digitizer offers everything needed to manage and adjust the system for optimum performance. The interface shows the status of key components, triggers, interlocks and a real-time event log.</p>',
                        'specifications' => [
                            ['name_ru' => 'Пиковая мощность РЧ', 'value_ru' => '3 – 10 МВт', 'name_en' => 'RF peak power', 'value_en' => '3 – 10 MW'],
                            ['name_ru' => 'Средняя мощность РЧ', 'value_ru' => 'до 10 кВт', 'name_en' => 'RF average power', 'value_en' => '10 kW (max)'],
                            ['name_ru' => 'Напряжение импульса', 'value_ru' => '115 – 190 кВ', 'name_en' => 'Pulse voltage', 'value_en' => '115 – 190 kV'],
                            ['name_ru' => 'Ток импульса', 'value_ru' => '90 – 140 А', 'name_en' => 'Pulse current', 'value_en' => '90 – 140 A'],
                            ['name_ru' => 'Вес (без масла, клистрона, соленоида)', 'value_ru' => 'ок. 900 кг, масло ~200 л', 'name_en' => 'Weight (excl. oil, klystron, solenoid)', 'value_en' => 'approx. 900 kg, oil ~200 l'],
                            ['name_ru' => 'Типовые клистроны', 'value_ru' => 'CPI (VKS8262*), THALES (TH2157*, TH2163, TH2165)', 'name_en' => 'Typical klystrons', 'value_en' => 'CPI (VKS8262*), THALES (TH2157*, TH2163, TH2165)'],
                        ],
                        'gallery' => [
                            '/storage/import/k-series.svg',
                        ],
                        'sort' => 10,
                    ],
                ],
            ],
            [
                'slug_ru' => 'e-series', 'slug_en' => 'e-series', 'code' => 'E-Series',
                'title_ru' => 'Модуляторы электронной пушки (E-Gun)', 'title_en' => 'E-Gun Modulators',
                'intro_ru' => 'Для диодных E-пушек с пиковой мощностью до 30 кВт и напряжением до 30 кВ.',
                'intro_en' => 'For diode E-guns with peak power up to 30 kW and voltage up to 30 kV.',
                'description_ru' => '<p>Модуляторы E-Series полностью твердотельные и предназначены для работы со всеми видами диодных электронных пушек с пиковой мощностью до 30 кВт и уровнем напряжения до 30 кВ. Разнесённая конструкция с отдельными блоком импульсов и танк-блоком упрощает интеграцию в систему.</p>',
                'description_en' => '<p>The E-Series modulators are fully solid-state and designed to operate all kinds of diode electron guns with peak power up to 30 kW and voltage up to 30 kV. The split design with separate pulse unit and tank unit simplifies system integration.</p>',
                'image' => '/storage/import/e-series.svg',
                'sort' => 30,
                'products' => [
                    [
                        'slug_ru' => 'e110d-i', 'slug_en' => 'e110d-i', 'code' => 'E110D-i',
                        'title_ru' => 'E110D-i', 'title_en' => 'E110D-i',
                        'intro_ru' => 'Твердотельный модулятор диодных E-пушек, до 30 кВт при напряжении до 30 кВ.',
                        'intro_en' => 'Solid-state diode E-gun modulator, up to 30 kW at voltage up to 30 kV.',
                        'description_ru' => '<p>E110D-i — твердотельный модулятор электронной пушки, спроектированный для работы со всеми видами диодных E-пушек с пиковой мощностью до 30 кВт и напряжением до 30 кВ. Может также работать с триодными пушками без управления током сетки. Разнесённая конструкция разделена на танк-блок и блок импульсов для удобства интеграции.</p><p>Полностью твердотельное исполнение обеспечивает высочайший уровень надёжности без необходимости сервиса и запасных частей. Устройство хорошо защищено от любых воздействий со стороны электронной пушки и соответствует высоким требованиям широкого круга применений, включая лучевую терапию и досмотровые комплексы.</p>',
                        'description_en' => '<p>E110D-i is a solid-state electron gun modulator designed to operate all kinds of diode E-guns at peak power up to 30 kW and voltage up to 30 kV. It can also drive triode guns without grid emission control. The split design is divided into a tank unit and a pulse unit for easy integration.</p><p>Fully solid-state construction delivers the highest level of reliability without the need for service or spare parts. The unit is well protected against stress from the E-gun and meets the demanding requirements of a wide range of applications, including radiation therapy and cargo scanning.</p>',
                        'specifications' => [
                            ['name_ru' => 'Напряжение импульса', 'value_ru' => '0 – 30 кВ', 'name_en' => 'Pulse voltage', 'value_en' => '0 – 30 kV'],
                            ['name_ru' => 'Ток импульса', 'value_ru' => '0 – 1 А', 'name_en' => 'Pulse current', 'value_en' => '0 – 1 A'],
                            ['name_ru' => 'Пиковая мощность модулятора', 'value_ru' => 'до 0,03 МВт', 'name_en' => 'Modulator peak', 'value_en' => '0 – 0.03 MW'],
                            ['name_ru' => 'Средняя мощность модулятора', 'value_ru' => 'до 0,04 кВт', 'name_en' => 'Modulator avg.', 'value_en' => '0 – 0.04 kW'],
                            ['name_ru' => 'Вес блока импульсов', 'value_ru' => '16 кг', 'name_en' => 'Pulse unit weight', 'value_en' => '16 kg'],
                            ['name_ru' => 'Вес танк-блока (с маслом)', 'value_ru' => '29 кг', 'name_en' => 'Tank unit weight (incl. oil)', 'value_en' => '29 kg'],
                        ],
                        'gallery' => [
                            '/storage/import/e-series.svg',
                        ],
                        'sort' => 10,
                    ],
                ],
            ],
            [
                'slug_ru' => 'pg-series', 'slug_en' => 'pg-series', 'code' => 'PG-Series',
                'title_ru' => 'Импульсные генераторы', 'title_en' => 'Pulse Generators',
                'intro_ru' => 'Для исследований и испытаний технологии PEF, пиковая мощность до 6,2 МВт.',
                'intro_en' => 'For PEF research and testing, with peak power up to 6.2 MW.',
                'description_ru' => '<p>Импульсные генераторы PG-Series охватывают широкий диапазон мощностей. PG050 предназначен для исследований и испытаний технологии импульсных электрических полей (PEF). Вместе с нашим прототипом PEF-камеры он легко адаптируется к конкретным задачам: по типу продукта, габаритам и параметрам импульсов.</p>',
                'description_en' => '<p>The PG-Series pulse generators cover a wide power range. PG050 is designed for research and testing of pulsed electric field (PEF) technology. Together with our PEF chamber prototype, it adapts easily to specific needs regarding food type, size and pulse specifications.</p>',
                'image' => '/storage/import/pg-series.svg',
                'sort' => 40,
                'products' => [
                    [
                        'slug_ru' => 'pg050', 'slug_en' => 'pg050', 'code' => 'PG050',
                        'title_ru' => 'PG050', 'title_en' => 'PG050',
                        'intro_ru' => 'Импульсный генератор для исследований PEF, пиковая мощность до 6,2 МВт.',
                        'intro_en' => 'Pulse generator for PEF research, peak power up to 6.2 MW.',
                        'description_ru' => '<p>PG050 — импульсный генератор, спроектированный для исследований и испытаний технологии PEF (импульсные электрические поля). Устройство формирует электрические импульсы с пиковой мощностью до 6,2 МВт и непревзойдённой производительностью.</p><p>Генераторы PG-Series применяются в требовательных промышленных приложениях и идеально подходят для PEF-обработки пищевых продуктов, а также для исследовательских задач, где нужны средне-мощные импульсные генераторы.</p>',
                        'description_en' => '<p>PG050 is a pulse generator designed for research and testing of PEF (pulsed electric field) technology. It produces electric pulses with peak power up to 6.2 MW and unparalleled performance.</p><p>PG-Series generators are used in demanding industrial applications and are perfectly suited for PEF food processing and research where mid-range pulse generators are needed.</p>',
                        'specifications' => [
                            ['name_ru' => 'Напряжение импульса', 'value_ru' => '30 – 52 кВ', 'name_en' => 'Pulse voltage', 'value_en' => '30 – 52 kV'],
                            ['name_ru' => 'Ток импульса', 'value_ru' => '30 – 120 А', 'name_en' => 'Pulse current', 'value_en' => '30 – 120 A'],
                            ['name_ru' => 'Пиковая мощность модулятора', 'value_ru' => '6,2 МВт', 'name_en' => 'Modulator peak', 'value_en' => '6.2 MW'],
                            ['name_ru' => 'Средняя мощность модулятора', 'value_ru' => '8 кВт', 'name_en' => 'Modulator avg.', 'value_en' => '8 kW'],
                            ['name_ru' => 'Вес (с маслом)', 'value_ru' => 'ок. 140 кг', 'name_en' => 'Weight (incl. oil)', 'value_en' => 'approx. 140 kg'],
                        ],
                        'gallery' => [
                            '/storage/import/pg-series.svg',
                        ],
                        'sort' => 10,
                    ],
                ],
            ],
        ];

        foreach ($families as $data) {
            $products = $data['products'] ?? [];
            unset($data['products']);

            $family = ProductFamily::firstOrCreate(
                ['slug_ru' => $data['slug_ru']],
                $data
            );

            foreach ($products as $productData) {
                $family->products()->firstOrCreate(
                    ['slug_ru' => $productData['slug_ru']],
                    $productData + ['product_family_id' => $family->id]
                );
            }
        }
    }

    private function seedApplications(): void
    {
        $apps = [
            [
                'slug_ru' => 'science', 'slug_en' => 'science',
                'title_ru' => 'Научные исследования', 'title_en' => 'Science',
                'intro_ru' => 'Импульсная энергетика для ускорителей, источников света и фундаментальных исследований.',
                'intro_en' => 'Pulsed power for accelerators, light sources and fundamental research.',
                'description_ru' => '<p>Импульсные модуляторы Компании применяются в крупнейших научных установках мира — синхротронах, источниках свободных электронных лазеров и гамма-источниках. Они высокоточны и обеспечивают стабильность импульсов в пределах 8 ppm, что необходимо для прорывных исследовательских задач.</p>',
                'description_en' => '<p>The Company\'s pulse modulators are used in the world\'s largest scientific facilities — synchrotrons, free-electron lasers and gamma sources. They are highly precise, delivering pulse stability within 8 ppm, as required for breakthrough research.</p>',
                'icon' => '/storage/import/app-science.svg',
                'image' => '/storage/img/science.jpeg',
                'sort' => 10,
            ],
            [
                'slug_ru' => 'medtech', 'slug_en' => 'medtech',
                'title_ru' => 'Медицина и медтехника', 'title_en' => 'MedTech',
                'intro_ru' => 'Лучевая терапия и радиохирургия: надёжные модуляторы для ускорителей.',
                'intro_en' => 'Radiotherapy and radiosurgery: reliable modulators for accelerators.',
                'description_ru' => '<p>Компания поставляет импульсные модуляторы для систем лучевой терапии и радиохирургии ведущим мировым производителям. Наши компактные решения занимают примерно треть пространства и обладают примерно на 30 % большей эффективностью по сравнению со стандартными технологиями старого поколения на тиратронных модуляторах с формированием импульса.</p>',
                'description_en' => '<p>The Company supplies pulse modulators for radiotherapy and radiosurgery systems to leading global manufacturers. Our compact designs occupy roughly one third of the space and deliver about 30% higher efficiency than standard older thyratron-switched pulse forming network technology.</p>',
                'icon' => '/storage/import/app-medtech.svg',
                'image' => '/storage/img/medtech.jpeg',
                'sort' => 20,
            ],
            [
                'slug_ru' => 'industry', 'slug_en' => 'industry',
                'title_ru' => 'Промышленность и дефектоскопия', 'title_en' => 'Industry',
                'intro_ru' => 'Рентгеновская дефектоскопия в машиностроении и контроль качества.',
                'intro_en' => 'Industrial X-ray inspection and non-destructive testing.',
                'description_ru' => '<p>В промышленности наши импульсные источники используются в рентгеновской дефектоскопии, контроле качества и досмотровых комплексах. Надёжность и точность импульсов обеспечивают стабильную работу и низкую стоимость владения.</p>',
                'description_en' => '<p>In industry, our pulsed power sources are used in X-ray NDT, quality control and security screening. Reliability and pulse precision ensure stable operation and low cost of ownership.</p>',
                'icon' => '/storage/import/app-industry.svg',
                'image' => '/storage/img/industry.jpeg',
                'sort' => 30,
            ],
            [
                'slug_ru' => 'security', 'slug_en' => 'security',
                'title_ru' => 'Безопасность и досмотр', 'title_en' => 'Security & Inspection',
                'intro_ru' => 'Досмотровые комплексы и системы радиационного контроля.',
                'intro_en' => 'Security screening and radiation inspection systems.',
                'description_ru' => '<p>Импульсные модуляторы применяются в досмотровых комплексах и системах сканирования грузов и контейнеров. Благодаря высокой повторяемости импульсов и надёжности обеспечивается точное и непрерывное формирование изображений.</p>',
                'description_en' => '<p>Pulse modulators are used in security screening and cargo/container scanning systems. High pulse repeatability and reliability enable accurate, continuous image formation.</p>',
                'icon' => '/storage/import/app-security.svg',
                'image' => '/storage/img/security.png',
                'sort' => 40,
            ],
        ];

        foreach ($apps as $data) {
            // Preserve application content/images edited in admin: seed only missing records.
            Application::firstOrCreate(['slug_ru' => $data['slug_ru']], $data);
        }
    }

    private function seedCases(): void
    {
        $cases = [
            [
                'slug_ru' => 'medtech-zap', 'slug_en' => 'medtech-zap',
                'title_ru' => 'Импульсная энергия для радиохирургии', 'title_en' => 'Pulsed power for radiosurgery',
                'intro_ru' => 'Совместный проект — модуляторы для систем радиохирургии ZAP Surgical.',
                'intro_en' => 'Collaboration with ZAP Surgical on modulators for radiosurgery systems.',
                'body_ru' => '<p>Модуляторы Компании стали ключевым компонентом в новых системах радиохирургии ZAP Surgical. Благодаря компактным размерам и высокой надёжности они обеспечивают точную и стабильную подачу импульсной энергии во время процедур.</p>',
                'body_en' => '<p>Company modulators became a key component in ZAP Surgical\'s new radiosurgery systems. Thanks to their compact size and high reliability, they deliver accurate and stable pulsed power throughout procedures.</p>',
                'image' => '/storage/import/case-medtech.svg',
                'is_featured' => true,
                'sort' => 10,
            ],
            [
                'slug_ru' => 'cern-science', 'slug_en' => 'cern-science',
                'title_ru' => 'Импульсная энергетика для новых открытий', 'title_en' => 'Pulsed power for new discoveries',
                'intro_ru' => 'Решения для научных установок и ускорителей частиц.',
                'intro_en' => 'Solutions for scientific facilities and particle accelerators.',
                'body_ru' => '<p>Для научных установок и ускорителей частиц Компания поставляет импульсные модуляторы, обеспечивающие высокую точность и стабильность импульсов. Наше оборудование работает в проектах крупнейших научных центров мира.</p>',
                'body_en' => '<p>The Company supplies pulse modulators for scientific facilities and particle accelerators, providing high precision and pulse stability. Our equipment operates in top scientific centers worldwide.</p>',
                'image' => '/storage/import/case-cern.svg',
                'is_featured' => false,
                'sort' => 20,
            ],
            [
                'slug_ru' => 'varian-radiotherapy', 'slug_en' => 'varian-radiotherapy',
                'title_ru' => 'Новая система лечения рака', 'title_en' => 'New cancer treatment system',
                'intro_ru' => 'Модуляторы для систем лучевой терапии Varian.',
                'intro_en' => 'Modulators for Varian radiotherapy systems.',
                'body_ru' => '<p>Компания была выбрана поставщиком импульсных модуляторов для новейшей платформы лучевой терапии в портфеле Varian — системы Halcyon. Наши модуляторы значительно компактнее и надёжнее традиционных аналогов и не требуют расходных материалов.</p>',
                'body_en' => '<p>The Company was selected to supply pulse modulators for the newest cancer treatment platform in Varian\'s portfolio — the Halcyon system. Our modulators are considerably smaller and more reliable than traditional alternatives and carry no consumables.</p>',
                'image' => '/storage/import/case-varian.svg',
                'is_featured' => false,
                'sort' => 30,
            ],
        ];

        foreach ($cases as $data) {
            // Preserve case studies edited in admin: seed only missing records.
            CaseStudy::firstOrCreate(['slug_ru' => $data['slug_ru']], $data);
        }
    }

    private function seedNews(): void
    {
        $posts = [
            [
                'slug_ru' => 'unveiling-m200-air-cooled-modulator', 'slug_en' => 'unveiling-m200-air-cooled-modulator',
                'category' => 'news',
                'title_ru' => 'Новый высокопроизводительный модулятор магнетрона M200', 'title_en' => 'New high-performance M200 magnetron modulator',
                'intro_ru' => 'Расширяем линейку модуляторов магнетрона: M200 обеспечивает пиковую мощность РЧ от 2,5 до 5 МВт для радиолокации, медицины и промышленности.',
                'intro_en' => 'Expanding the magnetron modulator lineup: M200 delivers 2.5 to 5 MW of RF peak power for radar, MedTech and industrial applications.',
                'published_at' => now()->subDays(5),
                'body_ru' => '<p>Мы рады представить новый твердотельный модулятор магнетрона M200. Устройство рассчитано на магнетроны в диапазоне от 2,5 до 5 МВт и доступно в исполнениях с одиночной или двойной энергией (M200D).</p><p>Благодаря воздушному охлаждению и низким первичным напряжениям модулятор обеспечивает высокую безопасность, сниженную стоимость владения и точный контроль формы импульса — востребованные качества для радиолокации, медицинских и промышленных применений.</p>',
                'body_en' => '<p>We are pleased to introduce the new solid-state M200 magnetron modulator. The unit handles magnetrons from 2.5 to 5 MW and is available in single or dual energy versions (M200D).</p><p>With air cooling and low primary voltages, the modulator delivers high safety, reduced cost of ownership and precise pulse-shape control — qualities valued in radar, medical and industrial applications.</p>',
                'image' => '/storage/import/m-series.svg',
            ],
            [
                'slug_ru' => 'm-series-pulse-modulators-webinar', 'slug_en' => 'm-series-pulse-modulators-webinar',
                'category' => 'event',
                'title_ru' => 'Открытый семинар по технологиям импульсной энергетики', 'title_en' => 'Open seminar on pulsed power technologies',
                'intro_ru' => 'Приглашаем на открытый семинар, посвящённый твердотельным импульсным технологиям и их применению.',
                'intro_en' => 'Join our open seminar on solid-state pulsed power technologies and their applications.',
                'published_at' => now()->subDays(12),
                'body_ru' => '<p>Проведём открытый семинар, посвящённый твердотельной импульсной энергетике. Расскажем о ключевых технологических концепциях — расщепленном сердечнике, параллельной коммутации и импульсном управлении — и о том, как они повышают точность и надёжность оборудования.</p>',
                'body_en' => '<p>We are hosting an open seminar on solid-state pulsed power. We will cover key technology concepts — split core, parallel switching and pulse-to-pulse control — and how they improve the precision and reliability of our equipment.</p>',
                'image' => '/storage/import/e-series.svg',
            ],
        ];

        foreach ($posts as $data) {
            // Preserve posts edited in admin: seed only missing records.
            Post::firstOrCreate(['slug_ru' => $data['slug_ru']], $data);
        }
    }

    private function seedPages(): void
    {
        // Placeholder banners (1920×800) until real photos are uploaded.
        // Applied only when a page has no banner yet, so re-seeding does not
        // overwrite images uploaded through the admin panel.
        $banners = [
            'technology' => 'banner-grid',
            'about' => 'banner-grid',
            'history' => 'banner-glow',
            'team' => 'banner-grid',
            'privacy' => 'banner-glow',
        ];

        $pages = [
            'technology' => [
                'title_ru' => 'Технология', 'title_en' => 'Technology',
                'blocks' => [
                    ['type' => 'intro', 'sort' => 10, 'content' => [
                        'ru' => [
                            'eyebrow' => 'Технология',
                            'title' => 'Твердотельная импульсная энергетика',
                            'text' => '<p>Наши уникальные технологические решения изменили правила отрасли. Надёжные и высокоточные импульсы обеспечивают повышенную готовность, производительность, значительно сниженное энергопотребление и меньшие затраты на обслуживание.</p><p>Инновация строится на трёх ключевых технологических концепциях: Split Core™, Parallel Switching™ и Pulse to Pulse Control™.</p>',
                        ],
                        'en' => [
                            'eyebrow' => 'Technology',
                            'title' => 'Solid-state pulsed power',
                            'text' => '<p>Our unique technology breakthroughs have changed the rules of the industry. Reliable and high-precision pulses lead to improved uptime, performance, significantly decreased power consumption and lower maintenance costs.</p><p>The innovation is built on three principle technology concepts: Split Core™, Parallel Switching™ and Pulse to Pulse Control™.</p>',
                        ],
                    ]],
                    ['type' => 'features', 'sort' => 20, 'content' => [
                        'ru' => [
                            'eyebrow' => 'Концепции',
                            'title' => 'Ключевые технологические решения',
                            'columns' => 3,
                            'items' => [
                                ['icon' => '1', 'title' => 'Split Core™', 'text' => 'Расщепление сердечника трансформатора снижает первичное напряжение до уровня, подходящего для серийных ключей, и разделяет управление и высоковольтную импульсную среду.'],
                                ['icon' => '2', 'title' => 'Parallel Switching™', 'text' => 'Сниженные напряжения позволяют использовать IGBT-ключи, обеспечивая более быстрый выход на рабочий режим и чистую форму импульса.'],
                                ['icon' => '3', 'title' => 'Pulse to Pulse Control™', 'text' => 'Цикл обратной связи непрерывно измеряет и регулирует питание, обеспечивая точную амплитуду и длительность каждого импульса.'],
                            ],
                        ],
                        'en' => [
                            'eyebrow' => 'Concepts',
                            'title' => 'Key technology solutions',
                            'columns' => 3,
                            'items' => [
                                ['icon' => '1', 'title' => 'Split Core™', 'text' => 'Splitting the pulse transformer core reduces primary voltage to a level suitable for commercial switches and separates control from the high-voltage pulse environment.'],
                                ['icon' => '2', 'title' => 'Parallel Switching™', 'text' => 'Reduced voltages allow IGBT switches, providing faster time-to-duty and a very clean pulse shape.'],
                                ['icon' => '3', 'title' => 'Pulse to Pulse Control™', 'text' => 'A feedback loop continuously measures and regulates the feed, delivering exact pulse amplitude and length.'],
                            ],
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 30, 'content' => [
                        'ru' => [
                            'title' => 'Надёжность, проверенная временем',
                            'text' => '<p>Первый модулятор, построенный и поставленный в Японию для применения в современной лучевой терапии, проработал почти 15 лет без сервисного обслуживания — ни одна деталь не была заменена. Годы испытаний в лабораториях и на реальном производстве подтверждают работоспособность этой концепции.</p><p>Сегодня наша уникальная конструкция твердотельных модуляторов используется по всему миру. Всё началось в 1995 году с поисков совершенного импульса, приведших к разработке трансформатора с расщеплённым сердечником.</p>',
                        ],
                        'en' => [
                            'title' => 'Proven reliability',
                            'text' => '<p>The very first modulator built and delivered to Japan for an advanced radiotherapy system ran for almost 15 years without service or maintenance — not a single part was replaced. Years of testing in laboratories and real production environments confirm this concept works.</p><p>Today our ingenious solid-state modulator design is used throughout the world. It all began in 1995 when the search for the perfect pulse led to the split-core transformer.</p>',
                        ],
                    ]],
                    ['type' => 'cta', 'sort' => 40, 'content' => [
                        'ru' => [
                            'title' => 'Поможем сформировать будущее импульсной энергетики',
                            'text' => 'Свяжитесь с нами, чтобы обсудить задачи импульсной энергетики.',
                            'primary_label' => 'Работайте с нами',
                            'primary_url' => '/contacts',
                            'secondary_label' => 'Контакты',
                            'secondary_url' => '/contacts',
                        ],
                        'en' => [
                            'title' => 'Help us form the future of pulsed power',
                            'text' => 'Contact us to discuss your pulsed power requirements.',
                            'primary_label' => 'Work with us',
                            'primary_url' => '/en/contacts',
                            'secondary_label' => 'Contacts',
                            'secondary_url' => '/en/contacts',
                        ],
                    ]],
                ],
            ],
            'about' => [
                'title_ru' => 'О компании', 'title_en' => 'About',
                'blocks' => [
                    ['type' => 'intro', 'sort' => 10, 'content' => [
                        'ru' => [
                            'eyebrow' => 'О компании',
                            'title' => 'НПП «Импульсные технологии»',
                            'text' => '<p>Компания находится в Западной Сибири, в Томске — академическом городе, исторически пропитанном наукой. Мы продолжаем традиции, проектируем и производим оборудование независимо — от идеи до готового результата, опираясь на собственную компонентную базу и технологические решения.</p>',
                        ],
                        'en' => [
                            'eyebrow' => 'About us',
                            'title' => 'IMPTECH Scientific & Production Enterprise',
                            'text' => '<p>The Company is located in Western Siberia, in Tomsk — an academic city steeped in science. We continue the tradition and design and build equipment independently, from idea to finished result, drawing on our own component base and technology solutions.</p>',
                        ],
                    ]],
                    ['type' => 'stats', 'sort' => 20, 'content' => [
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
                    ['type' => 'text', 'sort' => 30, 'content' => [
                        'ru' => [
                            'title' => 'Полный цикл',
                            'text' => '<p>Уникальные продукты и техподдержка стали результатом многолетних прорывных исследований в области твердотельных технологий. Мы не обещаем революций, а делаем так, чтобы оборудование работало стабильно и предсказуемо годами. Это главное, и это ценят.</p><p>Наше оборудование работает в проектах научных центров, разработчиков медицинской и промышленной техники. Предлагаемые решения востребованы там, где привыкли проверять каждую деталь.</p>',
                        ],
                        'en' => [
                            'title' => 'Full cycle',
                            'text' => '<p>Unique products and technical support resulted from years of breakthrough research in solid-state technology. We do not promise revolutions — we make equipment run reliably and predictably for years. That is what matters, and it is valued.</p><p>Our equipment works in the projects of research centers and developers of medical and industrial technology. Our solutions are in demand where every detail is checked.</p>',
                        ],
                    ]],
                ],
            ],
            'history' => [
                'title_ru' => 'История', 'title_en' => 'History',
                'blocks' => [
                    ['type' => 'intro', 'sort' => 10, 'content' => [
                        'ru' => [
                            'eyebrow' => 'История',
                            'title' => 'От лабораторной разработки — к лидерству в импульсной энергетике',
                            'text' => '<p>Наша история уходит корнями в сибирскую науку. Компания выросла из уникальной научной среды томских научно-исследовательских институтов — национального центра ядерной физики и электроники. Идейным вдохновителем стал не один человек, а целая научная школа талантливых учёных и инженеров.</p>',
                        ],
                        'en' => [
                            'eyebrow' => 'History',
                            'title' => 'From laboratory development to leadership in pulsed power',
                            'text' => '<p>Our story is rooted in Siberian science. The company grew out of the unique scientific environment of Tomsk research institutes — a national center for nuclear physics and electronics. Its inspiration was not a single person but an entire scientific school of talented scientists and engineers.</p>',
                        ],
                    ]],
                    ['type' => 'timeline', 'sort' => 20, 'content' => [
                        'ru' => [
                            'title' => 'Ключевые этапы',
                            'items' => [
                                ['year' => '1970', 'text' => 'Корни: Томск — город, где физика в крови. Наши инженеры выросли в институтах, где проектировали импульсную технику для науки и обороны.'],
                                ['year' => '2018–2022', 'text' => 'Технологический рывок. От модуляторов — к полному циклу: источники питания, РЧ-системы, соленоиды, СВЧ-тракты, защита от излучений.'],
                                ['year' => '2020', 'text' => 'Становление: первые заказы пришли оттуда, где ошибки не прощают, — научные центры и оборонные предприятия. Мы прошли проверку.'],
                                ['year' => '2022–2026', 'text' => 'Время перемен: расширение линейки, полный цикл производства.'],
                                ['year' => '2026…', 'text' => 'Новейшая история: импортозамещение, независимость, рост. Наше оборудование работает в науке, медицине, промышленности и оборонке — там, где проверяют каждую деталь.'],
                            ],
                        ],
                        'en' => [
                            'title' => 'Key milestones',
                            'items' => [
                                ['year' => '1970', 'text' => 'Roots: Tomsk, a city where physics is in the blood. Our engineers grew up in institutes designing pulsed power for science and defence.'],
                                ['year' => '2018–2022', 'text' => 'Technology leap. From modulators to the full cycle: power supplies, RF systems, solenoids, microwave circuits, radiation shielding.'],
                                ['year' => '2020', 'text' => 'Formation: the first orders came from places that do not forgive mistakes — research centers and defence enterprises. We passed the test.'],
                                ['year' => '2022–2026', 'text' => 'A time of change: expanding the lineup, full production cycle.'],
                                ['year' => '2026…', 'text' => 'Recent history: import substitution, independence, growth. Our equipment works in science, medicine, industry and defence — where every detail is scrutinised.'],
                            ],
                        ],
                    ]],
                ],
            ],
            'team' => [
                'title_ru' => 'Команда', 'title_en' => 'Team',
                'blocks' => [
                    ['type' => 'intro', 'sort' => 10, 'content' => [
                        'ru' => [
                            'eyebrow' => 'Команда',
                            'title' => 'Инженеры и учёные',
                            'text' => '<p>Над разработками работают инженеры и учёные, объединённые задачей создания надёжной импульсной энергетики.</p>',
                        ],
                        'en' => [
                            'eyebrow' => 'Team',
                            'title' => 'Engineers and scientists',
                            'text' => '<p>Our developments are driven by engineers and scientists united by the goal of reliable pulsed power.</p>',
                        ],
                    ]],
                    ['type' => 'media', 'sort' => 20, 'content' => [
                        'ru' => [
                            'title' => 'Наш коллектив',
                            'text' => '',
                        ],
                        'en' => [
                            'title' => 'Our team',
                            'text' => '',
                        ],
                    ]],
                ],
            ],
            'privacy' => [
                'title_ru' => 'Политика конфиденциальности и обработки персональных данных', 'title_en' => 'Privacy Policy and Personal Data Processing',
                'blocks' => [
                    ['type' => 'intro', 'sort' => 10, 'content' => [
                        'ru' => [
                            'eyebrow' => 'Политика конфиденциальности',
                            'title' => 'Политика в отношении обработки персональных данных',
                            'text' => '<p>Настоящая Политика определяет порядок обработки и защиты персональных данных посетителей и пользователей сайта и разработана в соответствии с Федеральным законом от 27.07.2006 № 152-ФЗ «О персональных данных» и Постановлением Правительства РФ от 15.09.2008 № 687.</p>',
                        ],
                        'en' => [
                            'eyebrow' => 'Privacy Policy',
                            'title' => 'Personal Data Processing Policy',
                            'text' => '<p>This Policy defines how we process and protect the personal data of visitors and users of the website and is developed in accordance with Federal Law N 152-FZ of 27.07.2006 "On Personal Data" and Resolution of the Government of the Russian Federation N 687 of 15.09.2008.</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 20, 'content' => [
                        'ru' => [
                            'title' => '1. Оператор персональных данных',
                            'body' => '<p><strong>Оператором персональных данных</strong> (далее — Оператор) является: <em>[Полное фирменное наименование организации]</em> (далее — Компания).</p><p><strong>ИНН:</strong> [ИНН] &nbsp; <strong>ОГРН:</strong> [ОГРН].</p><p><strong>Юридический адрес:</strong> [Юридический адрес].</p><p><strong>Адрес для корреспонденции и запросов:</strong> г. Томск, пр-кт Развития, 3, офис 118; e-mail: <a href="mailto:info@plspwr.ru">info@plspwr.ru</a>; тел.: <a href="tel:+73822999999">+7 (3822) 99 99 99</a>.</p><p class="text-slate-500 text-sm">Примечание: значения в квадратных скобках ([Полное наименование], [ИНН], [ОГРН], [Юридический адрес]) являются плейсхолдерами и подлежат замене на фактические реквизиты юридического лица перед публикацией.</p>',
                        ],
                        'en' => [
                            'title' => '1. Personal Data Controller',
                            'body' => '<p><strong>The personal data controller</strong> (the "Controller") is: <em>[Full legal company name]</em> (the "Company").</p><p><strong>TIN:</strong> [TIN] &nbsp; <strong>OGRN:</strong> [OGRN].</p><p><strong>Legal address:</strong> [Legal address].</p><p><strong>Correspondence and requests:</strong> Tomsk, Pr-kt Razvitiya, 3, office 118; e-mail: <a href="mailto:info@plspwr.ru">info@plspwr.ru</a>; tel.: <a href="tel:+73822999999">+7 (3822) 99 99 99</a>.</p><p class="text-slate-500 text-sm">Note: values in square brackets ([Full legal company name], [TIN], [OGRN], [Legal address]) are placeholders and must be replaced with the actual company details before publication.</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 30, 'content' => [
                        'ru' => [
                            'title' => '2. Общие положения',
                            'body' => '<p>2.1. Использование сайта означает безоговорочное согласие пользователя с настоящей Политикой и указанными в ней условиями обработки его персональной информации.</p><p>2.2. В случае несогласия с условиями Политики пользователь должен прекратить использование сайта.</p><p>2.3. Настоящая Политика применяется только к сайту и не распространяется на сторонние интернет-ресурсы, на которые могут быть размещены ссылки.</p><p>2.4. Оператор не проверяет достоверность персональных данных, предоставляемых пользователем, и не осуществляет контроль за их актуальностью. Пользователь самостоятельно несёт ответственность за предоставление достоверных сведений.</p>',
                        ],
                        'en' => [
                            'title' => '2. General Provisions',
                            'body' => '<p>2.1. Use of the website constitutes unconditional consent to this Policy and the terms of processing of your personal information set out herein.</p><p>2.2. If you do not agree with the terms of this Policy, you must stop using the website.</p><p>2.3. This Policy applies only to the website and does not extend to third-party resources to which links may be provided.</p><p>2.4. The Controller does not verify the accuracy of the personal data provided by users and does not monitor its relevance. The user is solely responsible for providing accurate information.</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 40, 'content' => [
                        'ru' => [
                            'title' => '3. Состав обрабатываемой информации',
                            'body' => '<p><strong>3.1. Информация, предоставляемая пользователем добровольно:</strong> имя, адрес электронной почты, номер телефона, наименование организации, тема обращения, текст сообщения, а также страница сайта, с которой направлено обращение. Данные передаются пользователем при заполнении форм обратной связи на сайте.</p><p><strong>3.2. Данные, собираемые автоматически:</strong> IP-адрес, тип браузера, операционная система, сведения о посещённых страницах и времени визита (файлы cookie, данные веб-аналитики, логи сервера).</p><p>3.3. Обработка персональных данных, специальных категорий (расовая, национальная принадлежность, состояние здоровья, политические и религиозные взгляды и т. п.) и биометрических данных сайтом не осуществляется.</p>',
                        ],
                        'en' => [
                            'title' => '3. Scope of Information Processed',
                            'body' => '<p><strong>3.1. Information provided voluntarily by the user:</strong> name, e-mail address, phone number, company name, subject, message text, and the page of the website from which the inquiry was submitted. This data is provided when filling in the contact forms on the website.</p><p><strong>3.2. Data collected automatically:</strong> IP address, browser type, operating system, information about visited pages and visit time (cookies, web analytics data, server logs).</p><p>3.3. The website does not process special categories of personal data (racial or ethnic origin, state of health, political or religious views, etc.) or biometric data.</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 50, 'content' => [
                        'ru' => [
                            'title' => '4. Цели и правовые основания обработки',
                            'body' => '<p><strong>4.1. Цели обработки:</strong></p><ul><li>установление обратной связи с пользователем, рассмотрение его обращений и запросов;</li><li>подготовка коммерческого предложения и дальнейшее взаимодействие по запросу пользователя;</li><li>улучшение качества работы сайта и сервисов Оператора.</li></ul><p><strong>4.2. Правовые основания обработки:</strong> согласие пользователя на обработку персональных данных (п. 1 ч. 1 ст. 6 Федерального закона № 152-ФЗ), а также действия, совершаемые по инициативе пользователя при обращении через сайт (п. 5 ч. 1 ст. 6 Федерального закона № 152-ФЗ).</p>',
                        ],
                        'en' => [
                            'title' => '4. Purposes and Legal Basis for Processing',
                            'body' => '<p><strong>4.1. Purposes of processing:</strong></p><ul><li>establishing feedback with the user, handling their inquiries and requests;</li><li>preparing a commercial offer and further interaction upon the user\'s request;</li><li>improving the quality of the website and the Controller\'s services.</li></ul><p><strong>4.2. Legal basis for processing:</strong> the user\'s consent to the processing of personal data (clause 1, part 1, article 6 of Federal Law N 152-FZ), as well as actions performed at the initiative of the user when submitting an inquiry through the website (clause 5, part 1, article 6 of Federal Law N 152-FZ).</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 60, 'content' => [
                        'ru' => [
                            'title' => '5. Принципы и условия обработки',
                            'body' => '<p>5.1. Обработка персональных данных осуществляется на законной и справедливой основе, с соблюдением принципов, установленных ст. 5 Федерального закона № 152-ФЗ.</p><p>5.2. Обрабатываются только те персональные данные, которые отвечают целям их обработки. Содержание и объём обрабатываемых данных соответствуют заявленным целям, избыточная обработка не допускается.</p><p>5.3. Оператор не передаёт персональные данные третьим лицам, за исключением случаев, предусмотренных действующим законодательством Российской Федерации.</p><p>5.4. Оператор не осуществляет трансграничную передачу персональных данных.</p><p>5.5. Оператор не принимает решений на основании исключительно автоматизированной обработки персональных данных, порождающих юридические последствия для пользователя.</p>',
                        ],
                        'en' => [
                            'title' => '5. Principles and Conditions of Processing',
                            'body' => '<p>5.1. Personal data is processed lawfully and fairly, in accordance with the principles established by Article 5 of Federal Law N 152-FZ.</p><p>5.2. Only the personal data that meets the purposes of processing is processed. The content and scope of the processed data correspond to the stated purposes; excessive processing is not permitted.</p><p>5.3. The Controller does not disclose personal data to third parties, except as provided for by the applicable law of the Russian Federation.</p><p>5.4. The Controller does not perform cross-border transfer of personal data.</p><p>5.5. The Controller does not make decisions based solely on automated processing of personal data that produce legal consequences for the user.</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 70, 'content' => [
                        'ru' => [
                            'title' => '6. Права субъекта персональных данных',
                            'body' => '<p>6.1. Пользователь вправе получать информацию, касающуюся обработки его персональных данных (ст. 14 Федерального закона № 152-ФЗ).</p><p>6.2. Пользователь вправе требовать уточнения своих персональных данных, их блокирования или уничтожения в случае, если они являются неполными, устаревшими, неточными, незаконно полученными или не являются необходимыми для заявленной цели обработки (ст. 14, 21 Федерального закона № 152-ФЗ).</p><p>6.3. Пользователь вправе в любой момент отозвать согласие на обработку персональных данных, направив соответствующий запрос Оператору. Отзыв согласия не распространяется на обработку, осуществляемую до его отзыва.</p><p>6.4. Для реализации прав пользователь направляет запрос на адрес электронной почты Оператора: <a href="mailto:info@plspwr.ru">info@plspwr.ru</a>. Запрос должен содержать сведения, позволяющие идентифицировать пользователя как субъекта персональных данных, либо сам запрос предоставляется пользователем лично.</p><p>6.5. Пользователь вправе обжаловать действия или бездействие Оператора в уполномоченном органе по защите прав субъектов персональных данных (Роскомнадзор) или в судебном порядке (ст. 17 Федерального закона № 152-ФЗ).</p>',
                        ],
                        'en' => [
                            'title' => '6. Rights of the Personal Data Subject',
                            'body' => '<p>6.1. The user is entitled to receive information concerning the processing of their personal data (Article 14 of Federal Law N 152-FZ).</p><p>6.2. The user may request the correction, blocking or destruction of their personal data if it is incomplete, outdated, inaccurate, unlawfully obtained or not necessary for the stated purpose of processing (Articles 14 and 21 of Federal Law N 152-FZ).</p><p>6.3. The user may at any time withdraw consent to the processing of personal data by sending a corresponding request to the Controller. Withdrawal of consent does not affect processing carried out prior to its withdrawal.</p><p>6.4. To exercise their rights, the user sends a request to the Controller\'s e-mail address: <a href="mailto:info@plspwr.ru">info@plspwr.ru</a>. The request must contain information enabling the user to be identified as the data subject, or be submitted in person.</p><p>6.5. The user may appeal the Controller\'s actions or inaction to the authorized body for the protection of data subjects\' rights (Roskomnadzor) or in court (Article 17 of Federal Law N 152-FZ).</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 80, 'content' => [
                        'ru' => [
                            'title' => '7. Меры по защите персональных данных',
                            'body' => '<p>7.1. Оператор принимает необходимые правовые, организационные и технические меры для защиты персональных данных от неправомерного или случайного доступа, уничтожения, изменения, блокирования, копирования, распространения, а также от иных неправомерных действий (ст. 19 Федерального закона № 152-ФЗ).</p><p>7.2. К числу принимаемых мер относятся: ограничение круга лиц, имеющих доступ к персональным данным; хранение данных в защищённой базе данных с ограниченным доступом; использование защищённого соединения при передаче данных.</p><p>7.3. Доступ к обработанным через сайт данным предоставляется только уполномоченным сотрудникам Оператора в объёме, необходимом для выполнения должностных обязанностей.</p>',
                        ],
                        'en' => [
                            'title' => '7. Personal Data Security Measures',
                            'body' => '<p>7.1. The Controller takes the necessary legal, organizational and technical measures to protect personal data from unlawful or accidental access, destruction, alteration, blocking, copying, distribution, and other unlawful actions (Article 19 of Federal Law N 152-FZ).</p><p>7.2. Measures taken include: restricting the circle of persons with access to personal data; storing data in a secure database with restricted access; using a secure connection when transmitting data.</p><p>7.3. Access to the data processed through the website is provided only to authorized employees of the Controller to the extent necessary to perform their duties.</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 90, 'content' => [
                        'ru' => [
                            'title' => '8. Сроки обработки и хранения',
                            'body' => '<p>8.1. Персональные данные обрабатываются в течение срока, необходимого для достижения целей обработки, либо до отзыва согласия пользователя.</p><p>8.2. По достижении целей обработки, при истечении срока хранения либо при отзыве согласия персональные данные подлежат уничтожению, обезличиванию или блокированию в порядке, установленном законодательством.</p><p>8.3. Данные, переданные через формы сайта, хранятся в базе данных Оператора и уничтожаются по мере наступления указанных обстоятельств либо по требованию субъекта персональных данных.</p>',
                        ],
                        'en' => [
                            'title' => '8. Processing and Storage Periods',
                            'body' => '<p>8.1. Personal data is processed for the period necessary to achieve the purposes of processing, or until the user withdraws consent.</p><p>8.2. When the purposes of processing are achieved, the storage period expires, or consent is withdrawn, personal data is subject to destruction, anonymization or blocking in accordance with applicable law.</p><p>8.3. Data submitted through the website forms is stored in the Controller\'s database and is destroyed as the stated circumstances arise or at the request of the data subject.</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 100, 'content' => [
                        'ru' => [
                            'title' => '9. Файлы cookie и данные веб-аналитики',
                            'body' => '<p>9.1. Сайт использует файлы cookie и аналогичные технологии для обеспечения корректной работы, улучшения пользовательского опыта и сбора статистики посещаемости.</p><p>9.2. Пользователь может в любой момент отключить использование файлов cookie в настройках своего браузера. При этом некоторые функции сайта могут работать некорректно.</p><p>9.3. Продолжение использования сайта означает согласие пользователя на использование файлов cookie.</p>',
                        ],
                        'en' => [
                            'title' => '9. Cookies and Web Analytics Data',
                            'body' => '<p>9.1. The website uses cookies and similar technologies to ensure correct operation, improve the user experience and collect traffic statistics.</p><p>9.2. The user may at any time disable the use of cookies in their browser settings. Some website features may then work incorrectly.</p><p>9.3. Continuing to use the website constitutes consent to the use of cookies.</p>',
                        ],
                    ]],
                    ['type' => 'text', 'sort' => 110, 'content' => [
                        'ru' => [
                            'title' => '10. Заключительные положения',
                            'body' => '<p>10.1. Оператор вправе вносить изменения в настоящую Политику. Новая редакция вступает в силу с момента её размещения на сайте, если иное не предусмотрено новой редакцией.</p><p>10.2. Актуальная редакция Политики постоянно доступна на странице по адресу: <a href="/privacy">/privacy</a>.</p><p>10.3. Редакция Политики: версия 1.0 от 03.09.2026.</p><p>По всем вопросам обработки персональных данных просим обращаться по адресу: <a href="mailto:info@plspwr.ru">info@plspwr.ru</a>.</p>',
                        ],
                        'en' => [
                            'title' => '10. Final Provisions',
                            'body' => '<p>10.1. The Controller may amend this Policy. The new version takes effect upon its publication on the website, unless otherwise provided by the new version.</p><p>10.2. The current version of the Policy is always available at: <a href="/en/privacy">/en/privacy</a>.</p><p>10.3. Policy version: 1.0 dated 03.09.2026.</p><p>For any questions regarding the processing of personal data, please contact: <a href="mailto:info@plspwr.ru">info@plspwr.ru</a>.</p>',
                        ],
                    ]],
                ],
            ],
        ];

        foreach ($pages as $slug => $data) {
            $blocks = $data['blocks'] ?? [];
            unset($data['blocks']);

            $page = Page::firstOrCreate(
                ['slug_ru' => $slug],
                $data + [
                    'slug_en' => $slug,
                    'is_active' => true,
                    'is_home' => false,
                    'template' => 'default',
                ]
            );

            if (! $page->banner_image && isset($banners[$slug])) {
                $page->forceFill(['banner_image' => '/storage/import/'.$banners[$slug].'.svg'])->save();
            }

            // Preserve page blocks/content edited in admin: seed blocks only when empty.
            if ($page->blocks()->exists()) {
                continue;
            }

            foreach ($blocks as $block) {
                $page->blocks()->create($block);
            }
        }
    }

    private function seedSections(): void
    {
        $sections = [
            'products' => [
                'title_ru' => 'Продукция',
                'title_en' => 'Products',
                'description_ru' => 'Высоковольтные импульсные модуляторы и РЧ-системы — полный цикл разработки, производства и испытаний.',
                'description_en' => 'High-voltage pulse modulators and RF power systems — full cycle of development, production and testing.',
            ],
            'applications' => [
                'title_ru' => 'Применения',
                'title_en' => 'Applications',
                'description_ru' => 'Наши решения для импульсной энергетики работают в самых требовательных отраслях.',
                'description_en' => 'Our pulsed power solutions serve the most demanding industries.',
            ],
            'cases' => [
                'title_ru' => 'Кейсы',
                'title_en' => 'Case studies',
                'description_ru' => 'Реальные задачи импульсной энергетики, которые мы решили для заказчиков по всему миру.',
                'description_en' => 'Real pulsed power challenges we have solved for customers worldwide.',
            ],
            'contacts' => [
                'title_ru' => 'Контакты',
                'title_en' => 'Contacts',
                'description_ru' => 'Мы всегда готовы обсудить ваш проект. Свяжитесь с нами — и мы ответим.',
                'description_en' => 'We are always ready to discuss your project. Contact us — we will answer.',
            ],
            'news' => [
                'title_ru' => 'Новости',
                'title_en' => 'News',
                'description_ru' => 'Новости компании и отрасли импульсной энергетики.',
                'description_en' => 'Company and pulsed power industry news.',
            ],
        ];

        // Placeholder banners (1920×800) until real photos are uploaded.
        // Applied only when a section page has no banner yet, so re-seeding
        // does not overwrite images uploaded through the admin panel.
        $banners = [
            'products' => 'banner-wave',
            'applications' => 'banner-grid',
            'cases' => 'banner-glow',
            'contacts' => 'banner-grid',
            'news' => 'banner-wave',
        ];

        foreach ($sections as $section => $data) {
            $page = Page::firstOrCreate(
                ['section' => $section],
                $data + [
                    'slug_ru' => null,
                    'slug_en' => null,
                    'is_active' => true,
                    'is_home' => false,
                    'template' => 'default',
                    'section' => $section,
                ]
            );

            if (! $page->banner_image && isset($banners[$section])) {
                $page->forceFill(['banner_image' => '/storage/import/'.$banners[$section].'.svg'])->save();
            }
        }
    }
}
