<?php

declare(strict_types=1);

namespace App\Controller\Users;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\ContentController;

class AuthorsContentController extends ContentController
{
    #[Route('/authors', name: 'index_authors_html', methods: ['GET'])]
    public function indexAuthors(): Response
    {
        $htmlFilePath = self::PUBLIC_PATH . '/authors.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('File not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }

    #[Route('/authors/{id<\d+>}', name: 'list_single_author_html', methods: ['GET'])]
    public function listSingleAuthors(int $id): Response
    {
        $htmlFilePath = self::PUBLIC_PATH . '/single-author.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('File not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }

    #[Route('/authors/create', name: 'create_authors_html', methods: ['GET'])]
    public function createAuthors(): Response
    {
        $htmlFilePath = self::PUBLIC_PATH . '/create-authors.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('File not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }
}
