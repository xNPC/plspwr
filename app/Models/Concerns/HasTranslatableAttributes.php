<?php

declare(strict_types=1);

namespace App\Models\Concerns;

trait HasTranslatableAttributes
{
    /**
     * Get an attribute for the current locale, falling back to the default
     * locale column, then to the raw attribute value.
     */
    public function getTranslation(string $attribute): mixed
    {
        $locale = app()->getLocale();
        $field = $attribute.'_'.$locale;

        if ($this->getAttribute($field) !== null && $this->getAttribute($field) !== '') {
            return $this->getAttribute($field);
        }

        $defaultField = $attribute.'_'.config('locale.default', 'ru');

        return $this->getAttribute($defaultField);
    }

    /**
     * Magic accessor: $model->title returns the localized value.
     * Only invoked when no real attribute/relation of that name exists.
     */
    public function __get($key)
    {
        if (
            ! $this->hasAttributeOrRelation($key)
            && method_exists($this, 'hasLocalizedField')
            && in_array($key, $this->localizedFields ?? [], true)
        ) {
            return $this->getTranslation($key);
        }

        return parent::__get($key);
    }

    protected function hasAttributeOrRelation(string $key): bool
    {
        return array_key_exists($key, $this->attributes)
            || $this->hasGetMutator($key)
            || method_exists($this, $key);
    }

    public function hasLocalizedField(string $key): bool
    {
        return in_array($key, $this->localizedFields ?? [], true);
    }
}
