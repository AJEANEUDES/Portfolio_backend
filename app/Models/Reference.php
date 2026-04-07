<?php

namespace App\Models;

use App\Enums\LetterStatus;
use App\Traits\Auditable;
use App\Traits\HasSlugAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;



class Reference extends Model
{
    use HasUuids, HasSlugAttribute, Auditable, HasTranslations;

    public array $translatable = [
        'title_translatable',
        'organization_translatable',
        'department_translatable',
        'relationship_translatable',
        'testimonial_translatable',
    ];

    protected $fillable = [
        'slug',
        'full_name',
        'title',
        'organization',
        'department',
        'photo',
        'organization_logo',
        'relationship',
        'relationship_period',
        'testimonial',
        'letter_file',
        'letter_status',
        'email',
        'phone',
        'linkedin_url',
        'website_url',
        'show_contact_info',
        'title_translatable',
        'organization_translatable',
        'department_translatable',
        'relationship_translatable',
        'testimonial_translatable',
        'order',
        'is_active',
    ];

    protected $casts = [
        'letter_status'    => LetterStatus::class,
        'show_contact_info'=> 'boolean',
        'is_active'        => 'boolean',
        'order'            => 'integer',
    ];

    protected function slugSource(): string
    {
        return 'full_name';
    }

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