<?php

declare(strict_types=1);

namespace App\Service\Authors;

use App\Repository\AuthorsRepository;

class AuthorService
{
    private AuthorsRepository $authorsRepository;

    public function __construct(AuthorsRepository $authorsRepository)
    {
        $this->authorsRepository = $authorsRepository;
    }

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
