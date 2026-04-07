<?php

namespace App\Enums;

enum WorkType: string
{
    case ON_SITE = 'on_site';
    case REMOTE = 'remote';
    case HYBRID = 'hybrid';

    public function label(): string
    {
        return match ($this) {
            self::ON_SITE => 'Sur site',
            self::REMOTE => 'Télétravail',
            self::HYBRID => 'Hybride',
        };
    }
}