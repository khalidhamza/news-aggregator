<?php

namespace App\Builders;

use App\Enums\NewsSource;
use App\Services\News\NewsArticle;
use Illuminate\Support\Carbon;

class NewsArticleBuilder
{
    private ?string $title = null;
    private ?string $description = null;
    private ?string $content = null;
    private ?string $author = null;
    private ?string $url = null;
    private ?string $imageUrl = null;
    private ?Carbon $publishedAt = null;
    private ?NewsSource $source = null;
    private ?string $category = null;
    private ?string $externalId = null;
    private ?string $externalSource = null;

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function setPublishedAt(Carbon|string|null $publishedAt): self
    {
        if ($publishedAt === null) {
            $this->publishedAt = null;
        } elseif ($publishedAt instanceof Carbon) {
            $this->publishedAt = $publishedAt;
        } else {
            $this->publishedAt = Carbon::parse($publishedAt);
        }
        return $this;
    }

    public function setSource(NewsSource $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function setExternalSource(string $source): self
    {
        $this->externalSource = $source;
        return $this;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function setExternalId(?string $externalId): self
    {
        $this->externalId = $externalId;
        return $this;
    }

    public function build(): NewsArticle
    {
        return new NewsArticle(
            title: $this->title ?? 'Untitled',
            description: $this->description,
            content: $this->content,
            author: $this->author,
            url: $this->url,
            imageUrl: $this->imageUrl,
            publishedAt: $this->publishedAt ?? now(),
            source: $this->source,
            category: $this->category,
            externalId: $this->externalId,
            externalSource: $this->externalSource
        );
    }

}
