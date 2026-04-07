<?php

namespace App\Enums;

enum ExperienceCategory: string
{
    case PAID_POSITION = 'paid_position';
    case FOUNDED = 'founded';
    case VOLUNTEER = 'volunteer';
    case INTERNSHIP = 'internship';

    public function label(): string
    {
        return match ($this) {
            self::PAID_POSITION => 'Emploi',
            self::FOUNDED => 'Fondé',
            self::VOLUNTEER => 'Bénévolat',
            self::INTERNSHIP => 'Stage',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PAID_POSITION => 'success',
            self::FOUNDED => 'info',
            self::VOLUNTEER => 'warning',
            self::INTERNSHIP => 'primary',
        };
    }
}