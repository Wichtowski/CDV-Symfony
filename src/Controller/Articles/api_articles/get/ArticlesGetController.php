<?php

declare(strict_types=1);

namespace App\Controller\Articles\api_articles\get;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use App\Controller\ArticlesController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/articles/get', name: 'api_articles_list')]
class ArticlesGetController extends AbstractController
{
    public function __construct(private ArticlesRepository $articlesRepository) {}

    #[Route('/all', name: 'api_articles_list', methods: ['GET'])]
    public function listArticles(): JsonResponse
    {
        $articles = $this->articlesRepository->findAll();
        $response = array_map(static function (Articles $article) {
            return [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
            ];
        }, $articles);

        return new JsonResponse($response, 200);
    }

    #[Route('/{id}', name: 'api_article_show', methods: ['GET'])]
    public function showArticle(int $id): JsonResponse
    {
        $article = $this->articlesRepository->find($id);

        if (!$article) {
            return new JsonResponse(['error' => 'Article not found'], 404);
        }

        return new JsonResponse([
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'author' => $article->getAuthor()->getName(),
        ], 200);
    }
}
