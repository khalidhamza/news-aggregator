<?php

namespace App\Services\News;

use App\Builders\NewsArticleBuilder;
use App\Enums\NewsSource;
use Illuminate\Support\Carbon;

class NewsArticle
{
    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $content,
        public ?string $author,
        public string $url,
        public ?string $imageUrl,
        public Carbon $publishedAt,
        public NewsSource $source,
        public ?string $category,
        public ?string $externalId,
        public ?string $externalSource,
    ) {}

    public static function builder(): NewsArticleBuilder
    {
        return new NewsArticleBuilder();
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
