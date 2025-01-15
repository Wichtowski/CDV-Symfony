<?php

declare(strict_types=1);

namespace App\Controller\Users\Authors;

use App\Entity\Users;
use App\Entity\Articles;
use App\Repository\UsersRepository;
use App\Service\Users\Authors\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api')]
class AuthorsGetController extends AbstractController
{
    public function __construct(private AuthorService $authorService) {}

    #[Route('/users/authors', name: 'list_all_authors', methods: ['GET'])]
    public function listAuthors(): JsonResponse
    {
        try {
            $authors = $this->authorService->getAllAuthors();
            
            return new JsonResponse($authors);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }


    #[Route('/users/authors/{authorID}', name: 'list_single_author_by_int', methods: ['GET'])]
    public function getAuthorByIndentifier(int|string $authorID): JsonResponse
    {
        try {
            $author = $this->authorService->getAuthor($authorID);
            
            return new JsonResponse([
                'id' => $author->getId(),
                'name' => $author->getName(),
                'email' => $author->getEmail(),
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    #[Route('/users/authors/articles/{authorID}', name: 'list_all_authors_articles', methods: ['GET'])]
    public function listAuthorsArticlesString(string $authorID): JsonResponse
    {
        try {
            $authorsArticles = $this->authorService->getAuthorsArticles($authorID);
            return new JsonResponse($authorsArticles);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }
}