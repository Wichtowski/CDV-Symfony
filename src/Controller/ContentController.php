<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends AbstractController
{
    protected const PUBLIC_PATH = __DIR__ . '/../../public';

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
}
