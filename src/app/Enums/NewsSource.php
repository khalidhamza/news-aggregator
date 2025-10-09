<?php

namespace App\Enums;
enum NewsSource: int
{
    case NEWSAPI    = 1;
    case GUARDIAN   = 2;
    case NYTIMES    = 3;

    public function getDisplayName(): string
    {
        return match($this) {
            self::NEWSAPI   => 'NewsAPI',
            self::GUARDIAN  => 'The Guardian',
            self::NYTIMES   => 'New York Times',
        };
    }
}
