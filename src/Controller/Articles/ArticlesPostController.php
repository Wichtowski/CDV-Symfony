<?php

declare(strict_types=1);

namespace App\Controller\Articles;

use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticlesPostController extends AbstractController
{
    #[IsGranted('ROLE_AUTHOR', statusCode: 403, exceptionCode: 50000 )]
    #[Route('/api/articles/create', name: 'api_create_article', methods: ['POST'])]
    public function __invoke(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!isset($data['title'], $data['content'], $data['author'])) {
                throw new \InvalidArgumentException('Invalid input data');
            }

            $author = $entityManager->getRepository(Author::class)->find($data['author']);
            if (!$author) {
                throw new \InvalidArgumentException('Author not found');
            }

            $article = new Articles();
            $article->setTitle($data['title']);
            $article->setContent($data['content']);
            $article->setAuthor($data['author']);
            $article->setCreatedAt(new \DateTime());
            $entityManager->persist($article);
            $entityManager->flush();

            return new JsonResponse(['success' => true, 'message' => 'Article created successfully!'], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
