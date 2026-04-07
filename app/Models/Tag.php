<?php

namespace App\Models;

use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasUuids, HasSlugAttribute, HasTranslations;

    public array $translatable = ['name_translatable'];

    protected $fillable = [
        'name',
        'slug',
        'name_translatable',
    ];

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function publications(): MorphToMany
    {
        return $this->morphedByMany(Publication::class, 'taggable');
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'taggable');
    }
}