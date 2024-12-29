<?php

declare(strict_types=1);

namespace App\Controller\Users\post;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PermissionService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserPermissionController extends AbstractController
{
    public function __construct(
        private PermissionService $permissionService,
        private JWTTokenManagerInterface $jwtManager,
        private UserProviderInterface $userProvider
    ) {}

    #[Route('/api/users/post/permission', name: 'users_permission', methods: ['POST'])]
    public function checkPermission(Request $request): JsonResponse
    {
        $token = $request->headers->get('Authorization');

        if (!$this->isTokenValid($token)) {
            return new JsonResponse(['error' => 'Invalid token'], 401);
        }
        $user = $this->getUser($email);
        $isAdmin = $this->permissionService->isAdmin($user);

        return new JsonResponse(['permissionGranted' => $isAdmin], 200);
    }

    private function isTokenValid(?string $token): bool
    {
        if ($token === null || !str_starts_with($token, 'Bearer ')) {
            return false;
        }

        $jwt = substr($token, 7);

        try {
            $decodedToken = $this->jwtManager->decodeFromJsonWebToken($jwt);
            $user = $this->userProvider->loadUserByUsername($decodedToken['username']);
            return $user !== null;
        } catch (\Exception $e) {
            return false;
        }
    }
}
