<?php

namespace App\Services\NewsService;

use App\Builders\NewsArticleBuilder;
use App\Enums\NewsSource;
use Illuminate\Support\Carbon;

class NewsArticle
{
    private function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly ?string $content,
        public readonly ?string $author,
        public readonly string $url,
        public readonly ?string $imageUrl,
        public readonly Carbon $publishedAt,
        public readonly NewsSource $source,
        public readonly ?string $category,
        public readonly ?string $externalId,
        public readonly ?string $externalSource,
    ) {}

    public static function builder(): NewsArticleBuilder
    {
        return new NewsArticleBuilder();
    }

    public static function create(
        $title,
        $description,
        $content,
        $author,
        $url,
        $imageUrl,
        $publishedAt,
        $source,
        $category,
        $externalId,
        $externalSource,
    ): NewsArticle
    {
        return new NewsArticle(
            $title,
            $description,
            $content,
            $author,
            $url,
            $imageUrl,
            $publishedAt,
            $source,
            $category,
            $externalId,
            $externalSource,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'author' => $this->author,
            'url' => $this->url,
            'image_url' => $this->imageUrl,
            'published_at' => $this->publishedAt,
            'source' => $this->source,
            'category' => $this->category,
            'external_id' => $this->externalId,
            'external_source' => $this->externalSource,
        ];
    }

}
