<?php

namespace App\Services\News;

use App\Enums\NewsSource;
use Illuminate\Support\Collection;

class NewsServiceFactory
{
    public static function make(NewsSource $source): NewsService
    {
        $serviceClass = $source->getServiceClass();
        return app($serviceClass);
    }

    public static function makeAll(): Collection
    {
//        return collect(NewsSource::cases());
        return collect(NewsSource::cases())
            ->map(fn($source) => self::make($source));
    }
}
