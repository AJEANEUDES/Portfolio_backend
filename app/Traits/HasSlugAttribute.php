<?php

namespace App\Traits;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

trait HasSlugAttribute
{
    use HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->slugSource())
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();  // Le slug ne change pas si on modifie le titre
    }

    /**
     * Champ source pour la génération du slug.
     * Peut être overridé dans chaque modèle.
     */
    protected function slugSource(): string
    {
        return 'name';
    }

    /**
     * Routing par slug — jamais par ID.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}