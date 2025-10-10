<?php

namespace App\Adapters;

use App\Enums\NewsSource;
use App\Services\News\NewsArticle;

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

    public static function fromGuardian(array $data): NewsArticle
    {
        return NewsArticle::builder()
            ->setTitle($data['webTitle'] ?? 'Untitled')
            ->setDescription($data['fields']['trailText'] ?? null)
            ->setContent($data['fields']['bodyText'] ?? null)
            ->setAuthor($data['references']['author'] ?? null)
            ->setUrl($data['webUrl'])
            ->setImageUrl($data['fields']['thumbnail'] ?? null)
            ->setPublishedAt($data['webPublicationDate'])
            ->setSource(NewsSource::GUARDIAN)
            ->setExternalSource($data['sectionName'] ?? null)
            ->setExternalId($data['id'] ?? null)
            ->setCategory($data['sectionName'] ?? null)
            ->build();
    }
}
