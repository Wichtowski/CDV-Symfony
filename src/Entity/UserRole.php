<?php
namespace App\Entity;

class UserRole
{
    public const ROLES = [
        'Admin' => 'ADMIN',
        'Moderator' => 'MODERATOR',
        'Author' => 'AUTHOR',
        'Subscriber' => 'SUBSCRIBER',
        'Guest' => 'GUEST',
    ];
}