<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Traits\Auditable;
use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasUuids, HasSlugAttribute, Auditable, SoftDeletes, HasTranslations;

    public array $translatable = [
        'title_translatable',
        'excerpt_translatable',
        'content_translatable',
        'seo_title_translatable',
        'seo_description_translatable',
    ];

    protected $fillable = [
        'slug',
        'title',
        'cover_image',
        'excerpt',
        'content',
        'status',
        'published_at',
        'reading_time',
        'seo_title',
        'seo_description',
        'author_id',
        'title_translatable',
        'excerpt_translatable',
        'content_translatable',
        'seo_title_translatable',
        'seo_description_translatable',
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'published_at' => 'datetime',
        'reading_time' => 'integer',
    ];

    protected function slugSource(): string
    {
        return 'title';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::PUBLISHED)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', PostStatus::DRAFT);
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post) {
            if ($post->isDirty('content')) {
                $wordCount = str_word_count(strip_tags($post->content));
                $post->reading_time = max(1, (int) ceil($wordCount / 200));
            }
        });
    }
}