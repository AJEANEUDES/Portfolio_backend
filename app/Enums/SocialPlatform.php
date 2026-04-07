<?php

namespace App\Enums;

enum SocialPlatform: string
{
    case LINKEDIN = 'linkedin';
    case GITHUB = 'github';
    case TWITTER = 'twitter';
    case EMAIL = 'email';
    case YOUTUBE = 'youtube';
    case WEBSITE = 'website';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::LINKEDIN => 'LinkedIn',
            self::GITHUB => 'GitHub',
            self::TWITTER => 'Twitter / X',
            self::EMAIL => 'Email',
            self::YOUTUBE => 'YouTube',
            self::WEBSITE => 'Site web',
            self::OTHER => 'Autre',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::LINKEDIN => 'heroicon-o-link',
            self::GITHUB => 'heroicon-o-code-bracket',
            self::TWITTER => 'heroicon-o-chat-bubble-left',
            self::EMAIL => 'heroicon-o-envelope',
            self::YOUTUBE => 'heroicon-o-play',
            self::WEBSITE => 'heroicon-o-globe-alt',
            self::OTHER => 'heroicon-o-link',
        };
    }
}