<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasUuids, HasSlugAttribute, Auditable, HasTranslations;

    public array $translatable = [
        'title_translatable',
        'description_translatable',
    ];

    protected $fillable = [
        'slug',
        'title',
        'description',
        'icon',
        'order',
        'is_active',
        'title_translatable',
        'description_translatable',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected function slugSource(): string
    {
        return 'title';
    }

    public function technologies(): MorphToMany
    {
        return $this->morphToMany(Technology::class, 'technologable');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}