<?php

declare(strict_types=1);

namespace App\Controller\Users\get;

use App\Entity\Users;
use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class ListAllAuthorArticlesController extends AbstractController
{
    public function __construct(private ArticlesRepository $articlesRepository) {}

    #[Route('/api/articles/get/author/{id}', name: 'api_articles_list_authors_all', methods: ['GET'])]
    public function listAuthors(int $id): JsonResponse
    {
        $authorsArticles = $this->articlesRepository->findAllByAuthorId($id);
        $data = [];
    
        foreach ($authorsArticles as $article) {
            $data[] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'author' => $article->getAuthor()->getName(),
                'createdAt' => $article->getCreatedAt()
            ];
        }
    
        return new JsonResponse($data);
    }
}