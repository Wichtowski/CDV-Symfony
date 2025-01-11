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
    public function listSingleArticle(int $id): JsonResponse
    {
        try {
            $article = $this->articleService->getSingleArticle($id);
            return new JsonResponse($article, 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
