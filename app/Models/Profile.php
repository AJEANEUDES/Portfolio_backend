<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Profile extends Model
{
    use HasUuids, Auditable, HasTranslations;

    public array $translatable = [
        'name_translatable',
        'title_translatable',
        'bio_translatable',
        'hero_phrases_translatable',
    ];

    protected $fillable = [
        'name',
        'title',
        'bio',
        'photo',
        'cv_file',
        'video_url',
        'hero_phrases',
        'email',
        'meta',
        'name_translatable',
        'title_translatable',
        'bio_translatable',
        'hero_phrases_translatable',
        'avatar',
    ];

    protected $casts = [
        'hero_phrases' => 'array',
        'meta' => 'array',
    ];
}