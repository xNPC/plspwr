<x-layouts.app>
    {{-- Hero --}}
    @php $products = $products ?? collect(); $applications = $applications ?? collect(); $cases = $cases ?? collect(); $posts = $posts ?? collect(); @endphp

    @include('blocks.hero', ['block' => null, 'content' => [
        'title' => 'Импульсная энергетика',
        'subtitle' => 'Системы впереди времени',
        'text' => 'Более 40 лет в импульсной энергетике. Надежные технологии. Новейшие разработки. Опыт реализации сложнейших проектов для ключевых отраслей по всему миру.',
        'badge' => 'НПП Импульсные технологии',
        'primary_label' => 'Наши разработки',
        'primary_url' => url('/products'),
        'secondary_label' => 'Контакты',
        'secondary_url' => url('/contacts'),
    ]])

    @include('blocks.intro', ['block' => null, 'content' => [
        'eyebrow' => 'О компании',
        'title' => 'Более 40 лет в импульсной энергетике',
        'text' => '<p>Надежные технологии. Новейшие разработки. Опыт реализации сложнейших проектов для ключевых отраслей по всему миру.</p><p>Продукты под конкретные задачи с полным циклом испытаний и гарантией стабильности параметров на всем протяжении срока эксплуатации.</p>',
        'link_label' => 'Технология',
        'link_url' => url('/technology'),
        'link2_label' => 'О компании',
        'link2_url' => url('/about'),
    ]])

    @include('blocks.products', ['block' => null, 'content' => [
        'eyebrow' => 'Продукция',
        'title' => 'Изготавливаемое оборудование',
        'description' => 'Высоковольтные импульсные модуляторы и системы импульсной энергетики полного цикла.',
    ]])

    @include('blocks.applications', ['block' => null, 'content' => [
        'eyebrow' => 'Применения',
        'title' => 'Области применения',
        'description' => 'Наши решения работают там, где проверяют каждую деталь.',
    ]])

    @include('blocks.stats', ['block' => null, 'content' => [
        'eyebrow' => 'Опыт',
        'title' => 'Наш опыт в цифрах',
    ]])

    @include('blocks.technology', ['block' => null, 'content' => [
        'eyebrow' => 'Технология',
        'title' => 'Лидерство в области твердотельных технологий',
        'text' => '<p>Компания ИМПТЕХ находится в Западной Сибири, в Томске — академическом городе, исторически пропитанном наукой. Продолжаем традиции, проектируем и производим оборудование независимо — от идеи до готового результата.</p>',
        'link_label' => 'Технология',
        'link_url' => url('/technology'),
        'link2_label' => 'О компании',
        'link2_url' => url('/about'),
        'points' => [
            'Проектирование и производство независимо — от идеи до результата',
            'Собственная компонентная база и технологические решения',
            'Уникальные продукты и техподдержка',
            'Работает стабильно и предсказуемо годами',
        ],
    ]])

    @include('blocks.cases', ['block' => null, 'content' => [
        'eyebrow' => 'Кейсы',
        'title' => 'Наши кейсы',
        'description' => 'Импульсная энергия для радиохирургии, науки и промышленности.',
    ]])

    @include('blocks.news', ['block' => null, 'content' => [
        'eyebrow' => 'Медиа',
        'title' => 'Новости',
    ]])

    @include('blocks.cta', ['block' => null, 'content' => [
        'title' => 'Технологии на результат. Всегда рядом.',
        'text' => 'Работайте с нами — от идеи до серийного производства.',
        'primary_label' => 'Работайте с нами',
        'primary_url' => url('/contacts'),
        'secondary_label' => 'Контакты',
        'secondary_url' => url('/contacts'),
    ]])
</x-layouts.app>
