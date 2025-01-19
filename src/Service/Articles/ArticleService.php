<?php

declare(strict_types=1);

namespace App\Service\Articles;

use App\Repository\ArticlesRepository;
use App\Formatter\ApiResponseFormatter;
use App\Exceptions\ArticleNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleService
{
    public function __construct(
        private ArticlesRepository $articlesRepository,
        private ApiResponseFormatter $apiResponseFormatter
    ) {}

    public static function formatArticle($article): array
    {
        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'author' => $article->getAuthor()->getName(),
            'created_at' => $article->getCreatedAt()->format('Y-m-d H:i'),
        ];
    }

    public function getAllArticles(): JsonResponse
    {
        try {

            $articles = $this->articlesRepository->findAll();
            
            if (!$articles) {
                throw new ArticleNotFoundException();
            }

            $data = [];
            foreach ($articles as $article) {
                $data[] = $this->formatArticle($article);
            }
            
            return $this->apiResponseFormatter
            ->withData($data)
            ->response();
        } catch (\Exception $e) {
            return $this->apiResponseFormatter
                ->withErrors([$e->getMessage()])
                ->withStatus($e->getCode() ?: 500)
                ->withMessage('Failed to retrieve articles')
                ->response();
        }
    }

    public function getSingleArticle(int $id): JsonResponse
    {
        try {
            $article = $this->articlesRepository->find($id);
            
            if (!$article) {
                throw new ArticleNotFoundException();
            }
            
            return $this->apiResponseFormatter  
            ->withData($this->formatArticle($article))
            ->response();
        } catch (\Exception $e) {
            return $this->apiResponseFormatter
                ->withErrors([$e->getMessage()])
                ->withStatus($e->getCode() ?: 500)
                ->withMessage('Failed to retrieve article')
                ->response();
        }
    }
}
