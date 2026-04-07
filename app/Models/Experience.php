<?php

namespace App\Models;

use App\Enums\ExperienceCategory;
use App\Enums\WorkType;
use App\Traits\Auditable;
use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Experience extends Model
{
    use HasUuids, HasSlugAttribute, Auditable, HasTranslations;

    public array $translatable = [
        'position_translatable',
        'company_translatable',
        'description_translatable',
    ];

    protected $fillable = [
        'slug',
        'position',
        'company',
        'company_logo',
        'company_url',
        'start_date',
        'end_date',
        'category',
        'description',
        'location',
        'work_type',
        'order',
        'is_active',
        'position_translatable',
        'company_translatable',
        'description_translatable',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'category' => ExperienceCategory::class,
        'work_type' => WorkType::class,
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected function slugSource(): string
    {
        return 'position';
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
        return $query->orderBy('order')->orderByDesc('start_date');
    }

    public function scopeByCategory($query, ExperienceCategory $category)
    {
        return $query->where('category', $category);
    }

    public function getIsPresentAttribute(): bool
    {
        return is_null($this->end_date);
    }

    public function getPeriodAttribute(): string
    {
        $start = $this->start_date->translatedFormat('M Y');
        $end = $this->is_present ? 'Présent' : $this->end_date->translatedFormat('M Y');
        return "{$start} — {$end}";
    }
}