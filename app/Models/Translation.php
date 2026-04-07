<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasUuids;

    protected $fillable = [
        'key',
        'group',
        'value_fr',
        'translations',
        'description',
    ];

    protected $casts = [
        'translations' => 'array',
    ];

    /**
     * Récupère la valeur traduite selon la langue.
     */
    public function getTranslated(string $locale): string
    {
        if ($locale === 'fr') {
            return $this->value_fr;
        }

        return $this->translations[$locale] ?? $this->value_fr;
    }
}