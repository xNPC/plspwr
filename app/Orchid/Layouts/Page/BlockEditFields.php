<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Page;

use Orchid\Screen\Fields\Matrix;

trait BlockEditFields
{
    /**
     * Return the field only when the current block type is one of the given types.
     */
    protected function row($field, array $types)
    {
        return in_array($this->blockType(), $types, true) ? $field : null;
    }

    protected function typeIs(...$types): bool
    {
        return in_array($this->blockType(), $types, true);
    }

    protected function blockType(): string
    {
        if (! $this->query) {
            return 'text';
        }

        $block = $this->query['block'] ?? null;

        return (string) ($block->type ?? $block['type'] ?? 'text');
    }

    protected function types(): array
    {
        return \App\Models\Block::TYPES;
    }

    /**
     * Textual block fields (localized) available per block type.
     * group => ['field_suffix' => [types...]]
     */
    protected function textFields(): array
    {
        return [
            'badge' => ['hero'],
            'eyebrow' => ['intro', 'technology', 'stats', 'text', 'form', 'timeline', 'features', 'gallery', 'media'],
            'title' => ['hero', 'intro', 'technology', 'products', 'applications', 'stats', 'cases', 'news', 'cta', 'text', 'form', 'timeline', 'features', 'gallery', 'faq', 'media'],
            'subtitle' => ['hero'],
            'description' => ['products', 'applications', 'stats', 'cases', 'features', 'timeline'],
            'text' => ['hero', 'intro', 'technology', 'cta', 'form', 'gallery'],
            'body' => ['text', 'media'],
            'link_label' => ['intro', 'technology'],
            'link2_label' => ['intro', 'technology'],
            'primary_label' => ['hero', 'cta'],
            'secondary_label' => ['hero', 'cta'],
            'image_alt' => ['media'],
        ];
    }

    /**
     * Titles used for text input fields, keyed by field suffix.
     */
    protected function textFieldTitles(): array
    {
        return [
            'badge' => 'Бейдж',
            'eyebrow' => 'Подзаголовок-метка',
            'title' => 'Заголовок',
            'subtitle' => 'Подзаголовок (акцентная строка)',
            'description' => 'Описание',
            'text' => 'Текст',
            'body' => 'Текст (HTML)',
            'link_label' => 'Ссылка 1 — текст',
            'link2_label' => 'Ссылка 2 — текст',
            'primary_label' => 'Основная кнопка — текст',
            'secondary_label' => 'Вторичная кнопка — текст',
            'image_alt' => 'Альтернативный текст изображения',
        ];
    }

    /**
     * Build the localized textual fields (e.g. block.content_ru_title, block.content_en_title)
     * filtered by the current block type.
     */
    protected function localeTextFields(string $locale): array
    {
        $fields = [];

        foreach ($this->textFields() as $suffix => $types) {
            if (! in_array($this->blockType(), $types, true)) {
                continue;
            }

            $make = \Orchid\Screen\Fields\Input::make("block.content_{$locale}_{$suffix}")
                ->title($this->textFieldTitles()[$suffix]);

            if ($suffix === 'text') {
                $make = \Orchid\Screen\Fields\TextArea::make("block.content_{$locale}_{$suffix}")
                    ->title($this->textFieldTitles()[$suffix])
                    ->rows(4);
            }

            if ($suffix === 'body') {
                $make = \Orchid\Screen\Fields\Quill::make("block.content_{$locale}_{$suffix}")
                    ->title($this->textFieldTitles()[$suffix])
                    ->height('260px')
                    ->base64(true);
            }

            $fields[] = $make;
        }

        return $fields;
    }

    /**
     * Build the localized Matrix groups (stats/items/points/images) for a locale.
     */
    protected function localeGroupFields(string $locale): array
    {
        $fields = [];

        if ($this->typeIs('stats')) {
            $fields[] = Matrix::make("block.content_{$locale}_stats")
                ->columns(['Значение' => 'value', 'Суффикс' => 'suffix', 'Подпись' => 'label'])
                ->fields([
                    'value' => \Orchid\Screen\Fields\Input::make()->placeholder('Значение'),
                    'suffix' => \Orchid\Screen\Fields\Input::make()->placeholder('Суффикс'),
                    'label' => \Orchid\Screen\Fields\Input::make()->placeholder('Подпись'),
                ])
                ->addRowLabel('Добавить показатель')
                ->title('Показатели');
        }

        if ($this->typeIs('timeline')) {
            $fields[] = Matrix::make("block.content_{$locale}_items")
                ->columns(['Год' => 'year', 'Текст' => 'text'])
                ->fields([
                    'year' => \Orchid\Screen\Fields\Input::make()->placeholder('Год'),
                    'text' => \Orchid\Screen\Fields\Input::make()->placeholder('Текст'),
                ])
                ->addRowLabel('Добавить этап')
                ->title('Этапы');
        }

        if ($this->typeIs('features')) {
            $fields[] = Matrix::make("block.content_{$locale}_items")
                ->columns(['Иконка' => 'icon', 'Заголовок' => 'title', 'Текст' => 'text'])
                ->fields([
                    'icon' => \Orchid\Screen\Fields\Input::make()->placeholder('Иконка'),
                    'title' => \Orchid\Screen\Fields\Input::make()->placeholder('Заголовок'),
                    'text' => \Orchid\Screen\Fields\Input::make()->placeholder('Текст'),
                ])
                ->addRowLabel('Добавить пункт')
                ->title('Пункты');
        }

        if ($this->typeIs('faq')) {
            $fields[] = Matrix::make("block.content_{$locale}_items")
                ->columns(['Вопрос' => 'q', 'Ответ' => 'a'])
                ->fields([
                    'q' => \Orchid\Screen\Fields\Input::make()->placeholder('Вопрос'),
                    'a' => \Orchid\Screen\Fields\Input::make()->placeholder('Ответ'),
                ])
                ->addRowLabel('Добавить вопрос')
                ->title('Вопросы');
        }

        if ($this->typeIs('technology')) {
            $fields[] = Matrix::make("block.content_{$locale}_points")
                ->columns(['Пункт' => 'point'])
                ->fields(['point' => \Orchid\Screen\Fields\Input::make()->placeholder('Пункт')])
                ->addRowLabel('Добавить пункт')
                ->title('Ключевые пункты');
        }

        if ($this->typeIs('gallery')) {
            $fields[] = Matrix::make("block.content_{$locale}_images")
                ->columns(['Изображение' => 'image'])
                ->fields(['image' => \Orchid\Screen\Fields\Input::make()->placeholder('Изображение (путь или ID)')])
                ->addRowLabel('Добавить изображение')
                ->title('Изображения');
        }

        return $fields;
    }
}