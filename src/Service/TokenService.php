<?php

declare(strict_types=1);

namespace App\Service;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

enum TokenValidationStatus: string {
    case VALID = 'valid';
    case INVALID = 'invalid';
}

class TokenService
{
    public function __construct(
        private JWTEncoderInterface $jwtEncoder,
        private UserProviderInterface $userProvider
    ) {}

    public function isTokenValid(?string $token): TokenValidationStatus
    {
        if ($token === null || !str_starts_with($token, 'Bearer ')) {
            return TokenValidationStatus::INVALID;
        }

        $jwt = substr($token, 7);

        try {
            $decodedToken = $this->jwtEncoder->decode($jwt);
            $user = $this->userProvider->loadUserByUsername($decodedToken['username']);
            return TokenValidationStatus::VALID;
        } catch (\Exception $e) {
            return TokenValidationStatus::INVALID;
        }
    }
}