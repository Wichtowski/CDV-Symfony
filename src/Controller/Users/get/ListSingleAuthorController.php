<?php

declare(strict_types=1);

namespace App\Controller\Users\get;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UsersRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ListSingleAuthorController extends AbstractController
{
    public function __construct(private UsersRepository $usersRepository) {}
    
    #[Route('/api/authors/get/{id}', name: 'list_single', methods: ['GET'])]
    public function getAuthor(int $id): Response
    {
        $author = $this->usersRepository->find($id);

        if (!$author) {
            return new JsonResponse(['error' => 'Author not found'], 404);
        }

        return new JsonResponse([
            'id' => $author->getId(),
            'name' => $author->getName(),
            'email' => $author->getEmail(),
        ], 200);
    }
}
