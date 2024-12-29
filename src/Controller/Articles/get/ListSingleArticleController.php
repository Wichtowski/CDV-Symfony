<?php

declare(strict_types=1);

namespace App\Controller\Articles\get;

use App\Service\Articles\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListSingleArticleController extends AbstractController
{
    public function __construct(private ArticleService $articleService) {}

    #[Route('/api/articles/get/{id}', name: 'list_single_article', methods: ['GET'])]
    public function listSingleArticle(string $id): JsonResponse
    {
        $articleId = (int) $id;
        $article = $this->articleService->getSingleArticle($articleId);
        if (!$article) {
            return new JsonResponse(['error' => 'Article not found'], 404);
        }

        return new JsonResponse($article, 200);
    }
}
