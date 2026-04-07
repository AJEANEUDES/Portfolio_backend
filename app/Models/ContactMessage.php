<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ContactMessage extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'email',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // --- Chiffrement de l'email en base ---

    public function setEmailAttribute(string $value): void
    {
        $this->attributes['email'] = Crypt::encryptString($value);
    }

    public function getEmailAttribute(string $value): string
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Throwable) {
            return $value; // Retourne la valeur brute si déchiffrement échoue
        }
    }

    // --- Scopes ---

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRecent($query)
    {
        return $query->orderByDesc('created_at');
    }
}