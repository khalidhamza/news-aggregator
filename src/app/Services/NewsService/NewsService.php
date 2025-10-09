<?php

namespace App\Services\NewsService;

use Exception;
use RuntimeException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class NewsService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(){
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
}
