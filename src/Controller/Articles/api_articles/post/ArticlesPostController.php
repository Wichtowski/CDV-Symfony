<?php

declare(strict_types=1);

namespace App\Controller\Articles\api_articles\post;

use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/articles/post', name: 'api_create_article', methods: ['POST'])]
class ArticlesPostController extends AbstractController
{
    #[Route('', name: 'api_create_article', methods: ['POST'])]
    public function __invoke(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!isset($data['title'], $data['content'])) {
                throw new \InvalidArgumentException('Invalid input data');
            }

            $article = new Articles();
            $article->setTitle($data['title']);
            $article->setContent($data['content']);
            $entityManager->persist($article);
            $entityManager->flush();

            return new JsonResponse(['success' => true, 'message' => 'Article created successfully!'], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
