<?php

namespace App\Http\Resources\V1\Concerns;

trait HasTranslatedFields
{
    protected function translated(string $field, ?string $locale = null): mixed
    {
        $locale = $locale ?? request()->header('Accept-Language', 'fr');

        // Prendre uniquement le code langue principal (ex: "fr-FR" → "fr")
        $locale = substr($locale, 0, 2);

        $transField = $field . '_translatable';

        if ($this->{$transField}) {
            $translations = is_string($this->{$transField})
                ? json_decode($this->{$transField}, true)
                : $this->{$transField};

            if (is_array($translations) && isset($translations[$locale])) {
                return $translations[$locale];
            }
        }

        return $this->{$field};
    }
}