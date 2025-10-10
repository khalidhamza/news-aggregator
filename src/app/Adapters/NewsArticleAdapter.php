<?php

namespace App\Adapters;

use App\Enums\NewsSource;
use App\Services\NewsService\NewsArticle;

class NewsArticleAdapter
{
    public static function fromNewsApi(array $data): NewsArticle
    {
        return NewsArticle::builder()
            ->setTitle($data['title'] ?? 'Untitled')
            ->setDescription($data['description'] ?? null)
            ->setContent($data['content'] ?? null)
            ->setAuthor($data['author'] ?? null)
            ->setUrl($data['url'])
            ->setImageUrl($data['urlToImage'] ?? null)
            ->setPublishedAt($data['publishedAt'])
            ->setSource(NewsSource::NEWSAPI)
            ->setExternalSource($data['source']['name'] ?? null)
            // ->setExternalId()
            // ->setCategory()
            ->build();
    }
}
