<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SiteSection extends Model
{
    use HasUuids, Auditable, HasTranslations;

    public array $translatable = [
        'title_translatable',
        'subtitle_translatable',
    ];

    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'title_translatable',
        'subtitle_translatable',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}