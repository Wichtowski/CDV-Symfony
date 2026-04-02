<?php

namespace App\Entity;

enum UserRole: string
{
    case Admin = 'ROLE_ADMIN';
    case Moderator = 'ROLE_MODERATOR';
    case Author = 'ROLE_AUTHOR';
    case Subscriber = 'ROLE_SUBSCRIBER';
    case Guest = 'ROLE_GUEST';
}