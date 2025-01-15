<?php

declare(strict_types=1);

namespace App\Service\Articles;

use App\Service\BaseService;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleService extends BaseService
{
    private ArticlesRepository $articlesRepository;

    public function __construct(ArticlesRepository $articlesRepository)
    {
        $this->articlesRepository = $articlesRepository;
    }

    private static function formatArticle($article): array
    {
        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'author' => $article->getAuthor()->getName(),
            'created_at' => $article->getCreatedAt()->format('Y-m-d H:i'),
        ];
    }

    public function getAllArticles(): array
    {
        $articles = $this->articlesRepository->findAll();
        return array_map(static function ($article) {
            return self::formatArticle($article);
        }, $articles);
    }

    public function getSingleArticle(int $id): array
    {
        try {
            $article = $this->articlesRepository->find($id);

            if (!$article) {
                $this->failResponder('Article not found', 404);
            }
            return $this->successResponder(self::formatArticle($article));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
