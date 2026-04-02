<?php

declare(strict_types=1);

namespace App\Controller\Users\Authors;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api')]
class AuthorPostController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN', statusCode: 403, exceptionCode: 10000 )]
    #[Route('/users/authors/create', name: 'create_author', methods: ['POST'])]
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
