<?php

declare(strict_types=1);

namespace App\Controller\Articles;

use App\Entity\Articles;
use App\Controller\ContentController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticlesContentController extends ContentController
{
    #[Route('/articles', name: 'list_all_articles_html', methods: ['GET'])]
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

    #[Route('/articles/{id<\d+>}', name: 'list_single_article_html', methods: ['GET'])]
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

    #[Route('/articles/create', name: 'articles_create_html', methods: ['GET'])]
    public function addArticles(): Response
    {
        $htmlFilePath = self::PUBLIC_PATH . '/create-articles.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('File not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }
}
