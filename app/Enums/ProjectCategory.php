<?php

namespace App\Enums;

enum ProjectCategory: string
{
    case CUSTOMER = 'customer';
    case PERSONAL = 'personal';
    case OPEN_SOURCE = 'open_source';
    case ACADEMIC = 'academic';

    public function label(): string
    {
        return match ($this) {
            self::CUSTOMER => 'Client',
            self::PERSONAL => 'Personnel',
            self::OPEN_SOURCE => 'Open Source',
            self::ACADEMIC => 'Académique',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CUSTOMER => 'success',
            self::PERSONAL => 'info',
            self::OPEN_SOURCE => 'warning',
            self::ACADEMIC => 'primary',
        };
    }
}