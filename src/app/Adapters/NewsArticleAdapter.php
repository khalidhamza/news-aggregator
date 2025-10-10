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
            ->setExternalId($data['id'] ?? null)
            ->setCategory($data['sectionName'] ?? null)
            ->build();
    }

    public static function fromNYTimes(array $data): NewsArticle
    {
        return NewsArticle::builder()
            ->setTitle($data['headline']['main'] ?? 'Untitled')
            ->setDescription($data['abstract'] ?? null)
            ->setContent($data['abstract'] ?? null)
            ->setAuthor($data['byline']['original'] ?? null)
            ->setUrl($data['web_url'])
            ->setImageUrl($data['multimedia']['default']['url'] ?? null)
            ->setPublishedAt($data['pub_date'] ?? null)
            ->setSource(NewsSource::NYTIMES)
            ->setExternalId($data['_id'] ?? null)
            ->setCategory($data['section_name'] ?? null)
            ->build();
    }
}
