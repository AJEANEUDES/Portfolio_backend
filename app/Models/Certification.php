<?php

namespace App\Models;

use App\Enums\CertificationCategory;
use App\Traits\Auditable;
use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Certification extends Model
{
    use HasUuids, HasSlugAttribute, Auditable, HasTranslations;

    public array $translatable = [
        'name_translatable',
        'description_translatable',
    ];

    protected $fillable = [
        'slug',
        'name',
        'issuer',
        'issuer_logo',
        'category',
        'credential_id',
        'verification_url',
        'badge_image',
        'issued_date',
        'expiration_date',
        'description',
        'skills',
        'name_translatable',
        'description_translatable',
        'is_featured',
        'order',
        'is_active',
    ];

    protected $casts = [
        'category'        => CertificationCategory::class,
        'issued_date'     => 'date',
        'expiration_date' => 'date',
        'skills'          => 'array',
        'is_featured'     => 'boolean',
        'is_active'       => 'boolean',
        'order'           => 'integer',
    ];

    protected function slugSource(): string
    {
        return 'name';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('issued_date');
    }

    // Accesseurs utiles
    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expiration_date) return false;
        return $this->expiration_date->isPast();
    }

    public function getIsValidAttribute(): bool
    {
        return !$this->is_expired;
    }
}