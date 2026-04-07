<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasUuids, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Contrôle l'accès au panel admin Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Liste blanche d'emails autorisés à accéder à l'admin
        $allowedEmails = [
            'admin@portfolio.com',
            'jean@portfolio.com', // email de développement
            'yajadjanohoun@gmail.com' // email de production
        ];

        return in_array($this->email, $allowedEmails);
    }
}