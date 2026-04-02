<?php

declare(strict_types=1);

namespace App\Controller\Articles;

use App\Entity\Articles;
use App\Service\Articles\ArticleService;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticlesPostController extends AbstractController
{
    public function __construct(
        private ArticleService $articleService,
        private EntityManagerInterface $manager
    ) {}

    #[Route('/api/articles/create', name: 'api_create_article', methods: ['POST'])]
    #[IsGranted('ROLE_AUTHOR', statusCode: 403, exceptionCode: 50000 )]
    public function __invoke(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        return $this->articleService->createArticle($data, $this->manager);
    }
}
