<?php

declare(strict_types=1);

namespace App\Controller\Users\post;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PermissionService;
use App\Service\TokenService;
use App\Service\TokenValidationStatus;

class UserPermissionController extends AbstractController
{
    public function __construct(
        private PermissionService $permissionService,
        private TokenService $tokenService
    ) {}

    #[Route('/api/users/post/permission', name: 'users_permission', methods: ['POST'])]
    public function checkPermission(Request $request): JsonResponse
    {
        $token = $request->headers->get('Authorization');

        if ($this->tokenService->isTokenValid($token) === TokenValidationStatus::INVALID) {
            return new JsonResponse(['error' => 'Invalid token'], 200);
        }
        $user = $this->getUser($email);
        $isAdmin = $this->permissionService->isAdmin($user);

        return new JsonResponse(['permissionGranted' => $isAdmin], 200);
    }
}