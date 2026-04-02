<?php

declare(strict_types=1);

namespace App\Controller\Articles;

use App\Service\Articles\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticlesGetController extends AbstractController
{
    public function __construct(private ArticleService $articleService) {}

    #[Route('/api/articles', name: 'api_articles_list_all', methods: ['GET'])]
    public function listAllArticles(): JsonResponse
    {
        return $this->articleService->getAllArticles();
    }

    #[Route('/api/articles/{id}', name: 'list_single_article', methods: ['GET'])]
    public function listSingleArticle(int $id): JsonResponse
    {
        return $this->articleService->getSingleArticle($id);
    }
}