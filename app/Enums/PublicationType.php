<?php

namespace App\Enums;

enum PublicationType: string
{
    case JOURNAL = 'journal';
    case CONFERENCE = 'conference';
    case THESIS = 'thesis';
    case TECHNICAL_REPORT = 'technical_report';
    case BOOK_CHAPTER = 'book_chapter';

    public function label(): string
    {
        return match ($this) {
            self::JOURNAL => 'Article de revue',
            self::CONFERENCE => 'Conférence',
            self::THESIS => 'Mémoire / Thèse',
            self::TECHNICAL_REPORT => 'Rapport technique',
            self::BOOK_CHAPTER => 'Chapitre de livre',
        };
    }
}