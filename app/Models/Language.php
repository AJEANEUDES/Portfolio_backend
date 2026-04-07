<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasUuids, Auditable;

    protected $fillable = [
        'code',
        'name',
        'native_name',
        'flag',
        'is_default',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
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

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // --- Helpers statiques ---

    public static function getDefaultCode(): string
    {
        return static::default()->first()?->code ?? 'fr';
    }

    public static function getActiveCodes(): array
    {
        return static::active()->ordered()->pluck('code')->toArray();
    }
}