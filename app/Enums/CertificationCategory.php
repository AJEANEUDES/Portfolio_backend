<?php

namespace App\Enums;

enum CertificationCategory: string
{
    case CLOUD = 'cloud';
    case DEVELOPMENT = 'development';
    case DATA_SCIENCE = 'data_science';
    case DEVOPS = 'devops';
    case SECURITY = 'security';
    case AI_ML = 'ai_ml';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::CLOUD => 'Cloud Computing',
            self::DEVELOPMENT => 'Développement',
            self::DATA_SCIENCE => 'Data Science',
            self::DEVOPS => 'DevOps',
            self::SECURITY => 'Sécurité',
            self::AI_ML => 'IA & Machine Learning',
            self::OTHER => 'Autre',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CLOUD => 'sky',
            self::DEVELOPMENT => 'blue',
            self::DATA_SCIENCE => 'purple',
            self::DEVOPS => 'green',
            self::SECURITY => 'red',
            self::AI_ML => 'amber',
            self::OTHER => 'gray',
        };
    }
}