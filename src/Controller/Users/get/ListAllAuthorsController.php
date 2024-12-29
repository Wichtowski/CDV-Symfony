<?php

declare(strict_types=1);

namespace App\Controller\Users\get;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class ListAllAuthorsController extends AbstractController
{
    public function __construct(private UsersRepository $usersRepository) {}

    #[Route('/api/authors/get/all', name: 'api_authors_list_all', methods: ['GET'])]
    public function listAuthors(): JsonResponse
    {
        $authors = $this->usersRepository->findAll();
        $data = [];
    
        foreach ($authors as $author) {
            $data[] = [
                'id' => $author->getId(),
                'email' => $author->getEmail(),
                'name' => $author->getName(),
            ];
        }
    
        return new JsonResponse($data);
    }
}