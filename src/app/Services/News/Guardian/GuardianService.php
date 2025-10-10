<?php

namespace App\Services\News\Guardian;

use App\Adapters\NewsArticleAdapter;
use App\Services\News\NewsService;
use Illuminate\Support\Collection;

class GuardianService extends NewsService
{
    protected function getApiKey(): string
    {
        return config('services.guardian.api_key');
    }

    protected function getBaseUrl(): string
    {
        return config('services.guardian.endpoint');
    }

    protected function buildRequestParams(array $filters): array
    {
        $fromDate = $toDate = null;
        if (! empty($filters['from_date'])) {
            $fromDate = date('Y-m-d', strtotime($filters['from_date']));
        }
        if (! empty($filters['to_date'])) {
            $toDate = date('Y-m-d', strtotime($filters['to_date']));
        }

        return [
            'api-key' => $this->apiKey,
            'show-fields' => 'thumbnail,trailText,bodyText',
            'show-references' => 'author',
            'q' => $filters['keyword'] ?? null,
            'from-date' => $fromDate,
            'to-date' => $toDate,
            'order-by' => $filters['sort_by'] ?? 'newest',
            'page-size' => $filters['per_page'] ?? 20,
            'page' => $filters['page'] ?? 1,
        ];
    }

    protected function transformResponse(array $response): Collection
    {
        return collect($response['response']['results'] ?? [])->map(function ($article) {
            return NewsArticleAdapter::fromGuardian($article);
        });
    }
}
