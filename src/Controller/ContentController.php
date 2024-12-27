<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class ContentController extends AbstractController
{
    private const PUBLIC_PATH = __DIR__ . '/../../public';

    public function __construct(private ArticlesRepository $articlesRepository) {}
    
    #[Route('/', name: 'index_html')]
    public function index(): Response
    {

        $htmlFilePath = self::PUBLIC_PATH . '/index.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('File not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
            ]);
    }

    #[Route('/articles', name: 'articles_html', methods: ['GET'])]
    public function listArticles(): Response
    {
        $htmlFilePath = self::PUBLIC_PATH . '/articles.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('File not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }

    #[Route('/articles/{id}', name: 'list_single_article', methods: ['GET'])]
    public function listSingleArticle(int $id): Response
    {
        $htmlFilePath = self::PUBLIC_PATH . '/single-article.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('File not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }

    #[Route('/articles/add', name: 'articles_add_html', methods: ['GET'])]
    public function addArticles(): Response
    {
        $htmlFilePath = self::PUBLIC_PATH . '/add-articles.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('File not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }


    #[Route('/authors', name: 'authors_html', methods: ['GET'])]
    public function listAuthors(): Response
    {
        $htmlFilePath = self::PUBLIC_PATH . '/authors.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('File not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }

}
