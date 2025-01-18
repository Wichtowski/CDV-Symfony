<?php

declare(strict_types=1);

namespace App\Service\Users\Authors;

use App\Service\BaseService;
use App\Repository\UsersRepository;
use App\Exceptions\AuthorNotFoundException;

class AuthorService extends BaseService
{

    public function __construct(private UsersRepository $usersRepository) {}

    public function getAllAuthors(): array
    {
        $authors = $this->usersRepository->findAllAuthors();

        if (!$authors) {
            throw new AuthorNotFoundException();
        }

        $data = [];
        foreach ($authors as $author) {
            $data[] = [
                'id' => $author->getId(),
                'name' => $author->getName(),
            ];
        }
        return $this->successResponder($data);
    }

    public function getAuthor(int|string $authorID)
    {
        $author = null; // Initialize the variable
        if (is_numeric($authorID) && (int)$authorID == $authorID) {
            $author = $this->usersRepository->find($authorID);
        } elseif (is_string($authorID)) {
            $authorID = str_replace('-', ' ', $authorID);
            $author = $this->usersRepository->findOneByName($authorID);
        } else {
            $author = null;
        }
        if (!$author) {
            throw $this->failResponder('Author not found', 404);
        }

        return $author;
    }

    public function getAuthorsArticles(int|string $id): array
    {
        $author = $this->getAuthor($id);
        
        $authorArticles = $this->usersRepository->findAllAuthorArticles($author->getId());

        if (!$authorArticles) {
            return $this->failResponder('Author does not have articles', 404);
        }

        $formattedArticles = array_map(static function ($article) {
            return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'author' => $article->getAuthor()->getName(),
            'createdAt' => $article->getCreatedAt()
            ];
        }, $authorArticles);

        return $formattedArticles;
    }

}
