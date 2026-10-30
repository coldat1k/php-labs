<?php

require_once __DIR__ . '/Article.php';

class Blog {
    private array $articles = [];

    public function addArticle(Article $article): void {
        $this->articles[] = $article;
    }

    public function getAllArticles(): array {
        return $this->articles;
    }

    public function findByAuthor(string $author): array {
        $result = [];
        $searchAuthor = strtolower(trim($author));

        foreach ($this->articles as $article) {
            if (strtolower(trim($article->getAuthor())) === $searchAuthor) {
                $result[] = $article;
            }
        }
        return $result;
    }

    public function listRecent(int $limit = 5): array {
        $sorted = $this->articles;
        usort($sorted, function (Article $a, Article $b) {
            return strtotime($b->getPublishedAt()) <=> strtotime($a->getPublishedAt());
        });
        return array_slice($sorted, 0, $limit);
    }
}