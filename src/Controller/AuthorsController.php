<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Authors;
use App\Repository\AuthorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class AuthorsController extends AbstractController
{
    private AuthorsRepository $authorsRepository;

    public function __construct(AuthorsRepository $authorsRepository)
    {
        $this->authorsRepository = $authorsRepository;
    }

    #[Route('api/authors', name: 'authors_list', methods: ['GET'])]
    public function listAuthors(): JsonResponse
    {
        $authors = $this->authorsRepository->findAll();
        $data = [];
    
        foreach ($authors as $author) {
            $data[] = [
                'id' => $author->getId(),
                'name' => $author->getName(),
            ];
        }
    
        return new JsonResponse($data);
    }
    
    #[Route('/author/add', name: 'authors_add_form', methods: ['GET'])]
    public function addAuthorsForm(): Response
    {
        $htmlFilePath = __DIR__ . '/../../public/authors-form.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('Form file not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }

    #[Route('/api/author', name: 'api_create_author', methods: ['POST'])]
    public function createAuthor(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (!$data || !isset($data['name'], $data['category'])) {
                throw new \InvalidArgumentException('Invalid input data');
            }
    
            $author = new Authors();
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