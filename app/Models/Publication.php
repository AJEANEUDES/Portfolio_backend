<?php

namespace App\Models;

use App\Enums\PublicationType;
use App\Traits\Auditable;
use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Publication extends Model
{
    use HasUuids, HasSlugAttribute, Auditable, HasTranslations;

    public array $translatable = [
        'title_translatable',
        'abstract_translatable',
    ];

    protected $fillable = [
        'slug',
        'title',
        'authors',
        'type',
        'venue',
        'year',
        'doi_url',
        'pdf_file',
        'abstract',
        'bibtex',
        'project_id',
        'is_featured',
        'order',
        'is_active',
        'title_translatable',
        'abstract_translatable',
    ];

    protected $casts = [
        'type' => PublicationType::class,
        'year' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected function slugSource(): string
    {
        return 'title';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('year');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, PublicationType $type)
    {
        return $query->where('type', $type);
    }
}