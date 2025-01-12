<?php

declare(strict_types=1);

namespace App\Controller\Users\get;

use App\Entity\Users;
use App\Entity\Articles;
use App\Service\Users\Authors\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class ListAllAuthorArticlesController extends AbstractController
{
    public function __construct(private AuthorService $authorService) {}

    #[Route('/api/authors/articles/{id}', name: 'api_list_all_authors_articles', methods: ['GET'])]
    public function listAuthorsArticles(int $id): JsonResponse
    {
        try {
            $authorsArticles = $this->authorService->getAuthorsArticles($id);
        
            return new JsonResponse($authorsArticles);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}