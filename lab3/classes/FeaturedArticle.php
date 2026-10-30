<?php

require_once __DIR__ . '/Article.php';

class FeaturedArticle extends Article {
    private string $bannerImage;
    private int $priority;

    public function __construct(string $title, string $content, string $author, string $publishedAt, string $bannerImage, int $priority) {
        parent::__construct($title, $content, $author, $publishedAt);
        $this->bannerImage = $bannerImage;
        $this->priority = $priority;
    }

    public function getBannerImage(): string {
        return $this->bannerImage;
    }

    public function getPriority(): int {
        return $this->priority;
    }

    public function getInfo(): string {
        return parent::getInfo() . " | [Закріплено, пріоритет: {$this->priority}]";
    }
}