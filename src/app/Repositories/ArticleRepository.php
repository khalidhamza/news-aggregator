<?php

namespace App\Repositories;

use App\Enums\NewsSource;
use App\Models\Article;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ArticleRepository
{
    public function bulkUpsert(Collection $articles): int
    {
        Log::info('Bulk upsert articles', ['articles_count' => $articles->count()]);

        if ($articles->isEmpty()) {
            return 0;
        }

        $data = $articles->map(fn($article) => [
            'title' => $article->title,
            'description' => $article->description,
            'content' => $article->content,
            'author' => $article->author,
            'url' => $article->url,
            'image_url' => $article->imageUrl,
            'published_at' => $article->publishedAt,
            'source' => $article->source->value,
            'category' => $article->category,
            'external_id' => $article->externalId,
            'external_source' => $article->externalSource,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        // Log::info('Upserting articles', [$data]);

        return Article::upsert(
            $data,
            ['url'],
            [
                'title',
                'description',
                'content',
                'author',
                'image_url',
                'published_at',
                'source',
                'category',
                'external_id',
                'external_source',
            ]
        );
    }

    public function getArticles(array $filters = []): CursorPaginator
    {
        $perPage = $filters['per_page'] ?? 20;
        return Article::query()
            ->when(! empty($filters['source']), function ($q) use ($filters) {
                $source = NewsSource::getIdFromName($filters['source']);
                $q->where('source', $source);
            })
            ->when(! empty($filters['category']), function ($q) use ($filters) {
                $q->where('category', $filters['category']);
            })
            ->when(! empty($filters['author']), function ($q) use ($filters) {
                $q->where('author', $filters['author']);
            })
            ->when(! empty($filters['from_date']), function ($q) use ($filters) {
                $q->whereDate('published_at', '>=', $filters['from_date']);
            })
            ->when(! empty($filters['to_date']), function ($q) use ($filters) {
                $q->whereDate('published_at', '<=', $filters['to_date']);
            })
            ->when(! empty($filters['keyword']), function ($q) use ($filters) {
                $q->whereFullText(['title', 'description', 'content'], $filters['keyword']);
            })
            ->cursorPaginate($perPage);

    }

    public function getCategories()
    {
        return Article::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }

    public function getAuthors()
    {
        return Article::select('author')
            ->whereNotNull('author')
            ->distinct()
            ->orderBy('author')
            ->pluck('author');
    }


}
