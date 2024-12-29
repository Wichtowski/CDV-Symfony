<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UsersRepository;

class PermissionService
{
    public function __construct(private UsersRepository $usersRepository) {}

    public function isAdmin(?UserInterface $user): bool
    {
        if ($user === null) {
            return false;
        }

        if (in_array('symfony-role-admin', $user->getRole(), true)) {
            return true;
        }

        return false;
    }
}
