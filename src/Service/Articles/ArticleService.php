<?php

declare(strict_types=1);

namespace App\Service\Articles;

use App\Repository\ArticlesRepository;

class ArticleService
{
    private ArticlesRepository $articlesRepository;

    public function __construct(ArticlesRepository $articlesRepository)
    {
        $this->articlesRepository = $articlesRepository;
    }

    public function getAllArticles(): array
    {
        $articles = $this->articlesRepository->findAll();
        return array_map(static function ($article) {
            return [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
            ];
        }, $articles);
    }

    public function getSingleArticle(int $id): ?array
    {
        $article = $this->articlesRepository->find($id);
        if (!$article) {
            return null;
        }

        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'author' => $article->getAuthor()->getName(),
        ];
    }
}
