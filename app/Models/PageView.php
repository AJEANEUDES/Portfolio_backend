<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasUuids;

    public $timestamps = false; // Uniquement created_at, géré manuellement

    protected $fillable = [
        'url',
        'referrer',
        'country',
        'device_type',
        'browser',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // --- Scopes ---

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    public function scopeForUrl($query, string $url)
    {
        return $query->where('url', $url);
    }
}