<?php
namespace App\Entity;

class UserRole
{
    public const ROLES = [
        'Admin' => 'ROLE_ADMIN',
        'Moderator' => 'ROLE_MODERATOR',
        'Author' => 'ROLE_AUTHOR',
        'Subscriber' => 'ROLE_SUBSCRIBER',
        'Guest' => 'ROLE_GUEST',
    ];
}