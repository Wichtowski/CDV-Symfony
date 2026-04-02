<?php

declare(strict_types=1);

namespace App\Service\Users\Authors;

use App\Repository\UsersRepository;
use App\Exceptions\AuthorNotFoundException;
use App\Exceptions\AuthorArticlesNotFoundException;
use App\Formatter\ApiResponseFormatter;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Users;
use App\Service\Articles;

class AuthorService
{

    public function __construct(
        private UsersRepository $usersRepository,
        private ApiResponseFormatter $apiResponseFormatter
    ) {}

    public function getAllAuthors(): JsonResponse
    {
        try {
            $authors = $this->usersRepository->findAllAuthors();
            
            if (!$authors) {
                throw new AuthorNotFoundException();
            }
    
            $data = [];
            foreach ($authors as $author) {
                $data[] = $this->formatAuthor($author);
            }
            
            return $this->apiResponseFormatter->withData($data)->response();

        } catch (\Exception $e) {
            return $this->apiResponseFormatter
                ->withErrors([$e->getMessage()])
                ->withStatus($e->getCode() ?: 500)
                ->withMessage('Failed to retrieve authors')
                ->response();
        }
    }

    public function getSingleAuthor(int|string $authorID)
    {
        try{
            $author = $this->findAuthorByIdOrName($authorID);

            return $this->apiResponseFormatter
                ->withData($this->formatAuthor($author))
                ->response();

        } catch (\Exception $e) {
            return $this->apiResponseFormatter
                ->withErrors([$e->getMessage()])
                ->withStatus($e->getCode() ?: 500)
                ->withMessage('Failed to retrieve author')
                ->response();
        }
    }

    public function getAuthorsArticles(int|string $id): JsonResponse
    {
        try {
            $author = $this->findAuthorByIdOrName($id)->getId();
            $authorArticles = $this->usersRepository->findAllAuthorArticles($author);

            if (!$authorArticles) {
                throw new AuthorArticlesNotFoundException();
            }

            $formattedArticles = array_map([$this, 'formatArticle'], $authorArticles);

            return $this->apiResponseFormatter
                ->withData($formattedArticles)
                ->response();

        } catch (\Exception $e) {
            return $this->apiResponseFormatter
                ->withErrors([$e->getMessage()])
                ->withStatus($e->getCode() ?: 500)
                ->withMessage('Failed to retrieve author articles')
                ->response();
        }
    }

    private function formatAuthor($author): array
    {
        return [
            'id' => $author->getId(),
            'name' => $author->getName(),
        ];
    }

    private function findAuthorByIdOrName($authorID): Users
    {
        $author = null;
        if (is_numeric($authorID) && (int)$authorID == $authorID) {
            $author = $this->usersRepository->find($authorID);
        } elseif (is_string($authorID)) {
            $authorID = str_replace('-', ' ', $authorID);
            $author = $this->usersRepository->findOneByName($authorID);
        } else {
            $author = null;
        }
        
        if (!$author) {
            throw new AuthorNotFoundException();
        }

        return $author;
    }
}
