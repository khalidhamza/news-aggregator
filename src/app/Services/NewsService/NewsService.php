<?php

namespace App\Services\NewsService;

use App\Repositories\ArticleRepository;
use Exception;
use RuntimeException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class NewsService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(private readonly ArticleRepository $repository){
        $this->apiKey = $this->getApiKey();
        $this->baseUrl = $this->getBaseUrl();
    }

    abstract protected function getApiKey(): string;
    abstract protected function getBaseUrl(): string;
    abstract protected function buildRequestParams(array $filters): array;
    abstract protected function transformResponse(array $response): Collection;

    protected function makeRequest(array $params): array
    {
        try {
            $response = Http::get($this->baseUrl, $params);
            return $response->json();
        } catch (Exception $e) {
            Log::error("Failed to fetch articles: {$e->getMessage()}");
             throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }

    public function getArticles(array $filters = []): Collection
    {
        $params = $this->buildRequestParams($filters);

        $response = $this->makeRequest($params);

        return $this->transformResponse($response);
    }

    public function syncArticles(array $filters = []): array
    {
        try {
            $articles = $this->getArticles($filters);

            $synced = $this->repository->bulkUpsert($articles);

            return [
                'success' => true,
                'source' => static::class,
                'synced' => $synced,
                'total' => $articles->count(),
            ];

        } catch (\Exception $e) {
            Log::error('Failed to sync articles', [
                'service' => static::class,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'source' => static::class,
                'error' => $e->getMessage(),
            ];
        }
    }
}
