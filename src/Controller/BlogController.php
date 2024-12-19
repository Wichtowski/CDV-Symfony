<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class BlogController extends AbstractController
{
    private ArticlesRepository $articlesRepository;

    public function __construct(ArticlesRepository $articlesRepository)
    {
        $this->articlesRepository = $articlesRepository;
        $this->responseStart = '<!DOCTYPE html><html><head><title>Articles</title><style>
            body { background-color: #121212; color: #ffffff; font-family: Arial, sans-serif; text-align: center; }
            h1 { color: #ffffff; }
            ul { list-style-type: none; margin: 0 auto; padding: 0; display: flex; flex-direction: column; align-items: flex-start; width: 80%; min-width: 300px; }
            li { margin: 10px 0; display: flex; align-items: center; justify-content:space-between; width: 100%; }
            button { background-color: #28a745; color: #ffffff; border: none; padding: 7px 9px; border-radius:6px; cursor: pointer; transition: 0.3s; }
            button:hover { background-color: #218838; transition: 0.3s; }
            .container { max-width: 600px; margin: 50px auto; padding: 20px; background: #1e1e1e; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5); }
        </style></head><body><div class="container">';
    }

    #[Route('/articles', name: 'blog', methods: ['GET'])]
    public function mainPage(): Response
    {
        $articles = $this->articlesRepository->findAll();
        $response = $this->responseStart;
        $response .= '<h1>Articles</h1><ul>';
        foreach ($articles as $index => $article) {
            $response .= sprintf(
                '<li>%d. %s <button onclick="window.location.href=\'/articles/%d\'">Read More</button></li>',
                $index + 1,
                htmlspecialchars($article->getTitle()),
                $article->getId()
            );
        }
        $response .= 
        '<li><button onclick="window.location.href=\'/article/add\'" style="margin: 16px auto;">Add Article</button>';
        $response .= 
        '<button onclick="window.location.href=\'/author/add\'" style="margin: 16px auto;">Add Author</button></li>';
        $response .= '</ul></div></body></html>';

        return new Response($response);
    }

    #[Route('/articles/{id}', name: 'article_show', methods: ['GET'])]
    public function showArticle(int $id): Response
    {
        $singleArticle = $this->articlesRepository->find($id);

        if (!$singleArticle) {
            throw $this->createNotFoundException('The article does not exist');
        }
        $response = $this->responseStart;
        $response .= '<h1>' . $singleArticle->getTitle() . '</h1><ul style="min-width: 700px">';
        $response .= $singleArticle->getContent() .'<br><button onclick="window.location.href=\'/articles\'" style="margin: 12px auto">Go Back</button>';
        $response .= '</ul></div></body></html>';
        return new Response($response);
    }

    #[Route('/article/add', name: 'article_add_form', methods: ['GET'])]
    public function addArticleForm(): Response
    {
        $htmlFilePath = __DIR__ . '/../../public/article-form.html';
        if (!file_exists($htmlFilePath)) {
            throw $this->createNotFoundException('Form file not found');
        }
        
        return new Response(file_get_contents($htmlFilePath), 200, [
            'Content-Type' => 'text/html',
        ]);
    }

    #[Route('/api/article', name: 'api_create_article', methods: ['POST'])]
    public function createArticle(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (!$data || !isset($data['title'], $data['content'])) {
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
