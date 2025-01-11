<?php

declare(strict_types=1);

namespace App\Service\Users\Authors;

use App\Service\BaseService;
use App\Repository\UsersRepository;

class AuthorService extends BaseService
{

    public function __construct(private UsersRepository $authorsRepository) {}

    public function getAllAuthors(): array
    {
        $authors = $this->authorsRepository->findAll();
        return array_map(static function ($author) {
            return [
                'id' => $author->getId(),
                'name' => $author->getName(),
                'bio' => $author->getBio(),
            ];
        }, $authors);
    }

    public function getAuthorsArticles(int $id): array
    {
        try {
            $author = $this->authorsRepository->findAllAuthorArticles($id);
            if (!$author) {
                throw new \Exception('Authors articles not found');
            }

            $articles = $author->getArticles();
            return array_map(static function ($article) {
                return [
                    'id' => $article->getId(),
                    'title' => $article->getTitle(),
                    'content' => $article->getContent(),
                    'author' => $article->getAuthor()->getName(),
                    'createdAt' => $article->getCreatedAt()
                ];
            }, $articles);
        } catch (\Exception $e) {
            throw new \Exception('Error getting authors articles');
        }
    }

    public function getAuthorById(int $id): ?array
    {
        $author = $this->authorsRepository->find($id);
        if (!$author) {
            return null;
        }

        return [
            'id' => $author->getId(),
            'name' => $author->getName(),
            'bio' => $author->getBio(),
        ];
    }
}
