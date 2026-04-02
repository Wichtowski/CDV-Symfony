<?php

declare(strict_types=1);

namespace App\Service\Articles;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use App\Formatter\ApiResponseFormatter;
use App\Exceptions\ArticleNotFoundException;
use App\Exceptions\AuthorNotFoundException;
use App\Exceptions\EmptyFieldException;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArticleService
{
    public function __construct(
        private ArticlesRepository $articlesRepository,
        private ApiResponseFormatter $apiResponseFormatter,
        private UsersRepository $usersRepository
    ) {}

    public function createArticle(array $data, EntityManagerInterface $manager): JsonResponse
    {
        try {
            $requiredFields = ['title', 'content', 'author'];
            $emptyFields = [];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    $emptyFields[] = $field;
                }
            }

            if (!empty($emptyFields)) {
                throw new EmptyFieldException(ucfirst(implode(', ', array_slice($emptyFields, 0, -1)) . ' & ' . end($emptyFields)) . " cannot be empty");
            }

            $author = $this->usersRepository->find($data['author']);
            if (!$author instanceof Users) {
                throw new AuthorNotFoundException();
            }
            // dd($author);

            $article = new Articles();
            $article->setTitle($data['title']);
            $article->setContent($data['content']);
            $article->setAuthor($author);
            $article->setCreatedAt(new \DateTime());
            $manager->persist($article);
            $manager->flush();

            return $this->apiResponseFormatter
                ->withData(['success' => true, 'message' => 'Article created successfully!'])
                ->withStatus(201)
                ->withAdditionalData([$data])
                ->response();
        } catch (\Exception $e) {
            return $this->apiResponseFormatter
                ->withErrors([$e->getMessage()])
                ->withStatus($e->getCode() ?: 500)
                ->withMessage('Failed to create article')
                ->response();
        }
    }

    public static function formatArticle($article): array
    {
        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'author' => $article->getAuthor()->getName(),
            'created_at' => $article->getCreatedAt()->format('Y-m-d H:i'),
        ];
    }

    public function getAllArticles(): JsonResponse
    {
        try {

            $articles = $this->articlesRepository->findAll();
            
            if (!$articles) {
                throw new ArticleNotFoundException();
            }

            $data = [];
            foreach ($articles as $article) {
                $data[] = $this->formatArticle($article);
            }
            
            return $this->apiResponseFormatter
            ->withData($data)
            ->response();
        } catch (\Exception $e) {
            return $this->apiResponseFormatter
                ->withErrors([$e->getMessage()])
                ->withStatus($e->getCode() ?: 500)
                ->withMessage('Failed to retrieve articles')
                ->response();
        }
    }

    public function getSingleArticle(int $id): JsonResponse
    {
        try {
            $article = $this->articlesRepository->find($id);
            
            if (!$article) {
                throw new ArticleNotFoundException();
            }
            
            return $this->apiResponseFormatter  
            ->withData($this->formatArticle($article))
            ->response();
        } catch (\Exception $e) {
            return $this->apiResponseFormatter
                ->withErrors([$e->getMessage()])
                ->withStatus($e->getCode() ?: 500)
                ->withMessage('Failed to retrieve article')
                ->response();
        }
    }
}
