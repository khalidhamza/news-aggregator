<?php

namespace App\Enums;
use App\Services\News\Guardian\GuardianService;
use App\Services\News\NewsApi\NewsApiService;
use App\Services\News\NYTimes\NYTimesService;
use Illuminate\Support\Collection;
use RuntimeException;

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
            default     => throw new RuntimeException('Service class not defined for this news source:'. $this->name),
        };
    }

    public function getServiceClass(): string
    {
        return match($this) {
            self::NEWSAPI   => NewsApiService::class,
            self::GUARDIAN  => GuardianService::class,
             self::NYTIMES  => NYTimesService::class,
            default     => throw new RuntimeException('Service class not defined for this news source:'. $this->name),
        };
    }

    public static function casesNames(): Collection
    {
        return collect(NewsSource::cases())->map(fn($source) => $source->name);
    }

    public static function getIdFromName(string $name): int
    {
        return match ($name) {
            'NEWSAPI'   => self::NEWSAPI->value,
            'GUARDIAN'  => self::GUARDIAN->value,
            'NYTIMES'   => self::NYTIMES->value,
            default     => 0,
        };
    }

}
