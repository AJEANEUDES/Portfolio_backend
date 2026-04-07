<?php

namespace App\Models;

use App\Enums\SocialPlatform;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasUuids, Auditable;

    protected $fillable = [
        'platform',
        'url',
        'label',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'platform' => SocialPlatform::class,
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // --- Scopes ---

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}