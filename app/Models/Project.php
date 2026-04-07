<?php

namespace App\Models;

use App\Enums\ProjectCategory;
use App\Traits\Auditable;
use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasUuids, HasSlugAttribute, Auditable, HasTranslations;

    public array $translatable = [
        'name_translatable',
        'description_translatable',
        'long_description_translatable',
    ];

    protected $fillable = [
        'slug',
        'name',
        'description',
        'long_description',
        'screenshot',
        'category',
        'website_url',
        'mobile_url',
        'github_url',
        'demo_url',
        'video_url',
        'video_thumbnail',
        'date',
        'is_featured',
        'order',
        'is_active',
        'name_translatable',
        'description_translatable',
        'long_description_translatable',
    ];

    protected $casts = [
        'date' => 'date',
        'category' => ProjectCategory::class,
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function technologies(): MorphToMany
    {
        return $this->morphToMany(Technology::class, 'technologable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('date');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, ProjectCategory $category)
    {
        return $query->where('category', $category);
    }
}