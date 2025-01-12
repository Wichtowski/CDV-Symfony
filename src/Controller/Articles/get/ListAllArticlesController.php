<?php

declare(strict_types=1);

namespace App\Controller\Articles\get;

use App\Service\Articles\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListAllArticlesController extends AbstractController
{

    public function __construct(private ArticleService $articleService) {}


    #[Route('/api/articles/all', name: 'api_articles_list_all', methods: ['GET'])]
    public function listAllArticles(): JsonResponse
    {
        try {
            $articles = $this->articleService->getAllArticles();
            return new JsonResponse($articles, 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}