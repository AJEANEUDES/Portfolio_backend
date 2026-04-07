<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Technology extends Model
{
    use HasUuids, HasSlugAttribute, Auditable, HasTranslations;

    public array $translatable = ['description_translatable'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'description_translatable',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function services(): MorphToMany
    {
        return $this->morphedByMany(Service::class, 'technologable');
    }

    public function experiences(): MorphToMany
    {
        return $this->morphedByMany(Experience::class, 'technologable');
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'technologable');
    }

    public function educations(): MorphToMany
    {
        return $this->morphedByMany(Education::class, 'technologable');
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