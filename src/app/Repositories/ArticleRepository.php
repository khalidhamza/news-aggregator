<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ArticleRepository
{
    public function bulkUpsert(Collection $articles): int
    {
        Log::info('Bulk upsert articles', ['articles' => $articles]);

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

        Log::info('Upserting articles', [$data]);

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
}
