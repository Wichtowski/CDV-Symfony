<?php

declare(strict_types=1);

namespace App\Controller\Users\Authors;

use App\Service\Users\Authors\AuthorService;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class AuthorsGetController extends AbstractController
{
    public function __construct(private AuthorService $authorService) {}

    #[Route('/users/authors', name: 'list_all_authors', methods: ['GET'])]
    public function listAuthors(): JsonResponse
    {
        return $this->authorService->getAllAuthors();
    }

    #[Route('/users/authors/{authorID}', name: 'list_single_author_by_int', methods: ['GET'])]
    public function getAuthorByIndentifier(int|string $authorID): JsonResponse
    {
        return $this->authorService->getSingleAuthor($authorID);
    }

    #[Route('/users/authors/articles/{authorID}', name: 'list_all_authors_articles', methods: ['GET'])]
    public function listAuthorsArticlesString(string $authorID): JsonResponse
    {
        return $this->authorService->getAuthorsArticles($authorID);
    }
}