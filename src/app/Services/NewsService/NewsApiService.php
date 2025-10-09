<?php

namespace App\Services\NewsService;

use App\Adapters\NewsArticleAdapter;
use Illuminate\Support\Collection;

class NewsApiService extends NewsService
{

    protected function getApiKey(): string
    {
        return config('services.newsapi.api_key');
    }

    protected function getBaseUrl(): string
    {
        return config('services.newsapi.endpoint');
    }

    protected function buildRequestParams(array $filters): array
    {
        return [
            'apiKey' => $this->apiKey,
            'q' => $filters['keyword'] ?? null,
            'from' => $filters['from_date'] ?? null,
            'to' => $filters['to_date'] ?? null,
            'language' => $filters['language'] ?? 'en',
            'sortBy' => $filters['sort_by'] ?? 'publishedAt',
            'pageSize' => $filters['per_page'] ?? 20,
            'page' => $filters['page'] ?? 1,
        ];
    }

    protected function transformResponse(array $response): Collection
    {
        return collect($response['articles'] ?? [])->map(function ($article) {
            return NewsArticleAdapter::fromNewsApi($article);
        });
    }
}
