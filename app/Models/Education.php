<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Education extends Model
{
    use HasUuids, HasSlugAttribute, Auditable, HasTranslations;

    protected $table = 'educations';

    public array $translatable = [
        'degree_translatable',
        'institution_translatable',
        'description_translatable',
    ];

    protected $fillable = [
        'slug',
        'degree',
        'institution',
        'institution_logo',
        'institution_url',
        'start_date',
        'end_date',
        'description',
        'mention',
        'location',
        'order',
        'is_active',
        'degree_translatable',
        'institution_translatable',
        'description_translatable',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected function slugSource(): string
    {
        return 'degree';
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

    public function getIsPresentAttribute(): bool
    {
        return is_null($this->end_date);
    }

    public function getPeriodAttribute(): string
    {
        $start = $this->start_date->translatedFormat('M Y');
        $end = $this->is_present ? 'En cours' : $this->end_date->translatedFormat('M Y');
        return "{$start} — {$end}";
    }
}