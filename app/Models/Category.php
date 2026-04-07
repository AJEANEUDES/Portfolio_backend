<?php

namespace App\Models;

use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasUuids, HasSlugAttribute, HasTranslations;

    public array $translatable = ['name_translatable'];

    protected $fillable = [
        'name',
        'slug',
        'type',
        'name_translatable',
    ];

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'categorizable');
    }

    public function publications(): MorphToMany
    {
        return $this->morphedByMany(Publication::class, 'categorizable');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}