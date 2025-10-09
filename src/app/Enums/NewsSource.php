<?php

namespace App\Enums;
use App\Services\NewsService\NewsApiService;
use RuntimeException;

enum NewsSource: int
{
    case NEWSAPI    = 1;
//    case GUARDIAN   = 2;
//    case NYTIMES    = 3;

    public function getDisplayName(): string
    {
        return match($this) {
            self::NEWSAPI   => 'NewsAPI',
//            self::GUARDIAN  => 'The Guardian',
//            self::NYTIMES   => 'New York Times',
            default     => throw new RuntimeException('Service class not defined for this news source:'. $this->name),
        };
    }

    public function getServiceClass(): string
    {
        return match($this) {
            self::NEWSAPI   => NewsApiService::class,
            // self::GUARDIAN  => 'The Guardian',
            // self::NYTIMES   => 'New York Times',
            default     => throw new RuntimeException('Service class not defined for this news source:'. $this->name),
        };
    }


}
