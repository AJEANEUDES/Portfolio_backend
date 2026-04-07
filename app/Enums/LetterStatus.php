<?php

namespace App\Enums;

enum LetterStatus: string
{
    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case ON_REQUEST = 'on_request';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Lettre disponible',
            self::PENDING => 'En attente',
            self::ON_REQUEST => 'Sur demande',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::AVAILABLE => 'success',
            self::PENDING => 'warning',
            self::ON_REQUEST => 'info',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::AVAILABLE => 'heroicon-o-check-circle',
            self::PENDING => 'heroicon-o-clock',
            self::ON_REQUEST => 'heroicon-o-envelope',
        };
    }
}