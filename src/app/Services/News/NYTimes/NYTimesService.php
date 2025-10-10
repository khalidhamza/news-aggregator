<?php

namespace App\Services\News\NYTimes;

use App\Adapters\NewsArticleAdapter;
use App\Services\News\NewsService;
use Illuminate\Support\Collection;

class NYTimesService extends NewsService
{
    protected function getApiKey(): string
    {
        return config('services.nytimes.api_key');
    }

    protected function getBaseUrl(): string
    {
        return config('services.nytimes.endpoint');
    }

    protected function buildRequestParams(array $filters): array
    {
        $fromDate = $toDate = null;
        if (! empty($filters['from_date'])) {
            $fromDate = date('Ymd', strtotime($filters['from_date']));
        }
        if (! empty($filters['to_date'])) {
            $toDate = date('Ymd', strtotime($filters['to_date']));
        }

        return [
            'api-key' => $this->apiKey,
            'q' => $filters['keyword'] ?? null,
            'begin_date' => $fromDate,
            'end_date' => $toDate,
            'sort' => $filters['sort_by'] ?? 'newest',
            'page' => $filters['page'] ?? 1,
        ];
    }

    protected function transformResponse(array $response): Collection
    {
        return collect($response['response']['docs'] ?? [])->map(function ($article) {
            return NewsArticleAdapter::fromNYTimes($article);
        });
    }

}
