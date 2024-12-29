<?php

declare(strict_types=1);

namespace App\Controller\Users\post;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateAuthorController extends AbstractController
{
    #[Route('/api/authors/post/create', name: 'create_author', methods: ['POST'])]
    public function createAuthor(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (!$data || !isset($data['name'], $data['category'])) {
                throw new \InvalidArgumentException('Invalid input data');
            }
    
            $author = new Users();
            $author->setName($data['name']);
            $author->setCategory($data['category']);
            $entityManager->persist($author);
            $entityManager->flush();
    
            return new JsonResponse(['success' => true, 'message' => 'Author created successfully!'], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
