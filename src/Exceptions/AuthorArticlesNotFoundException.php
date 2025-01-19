<?php
declare(strict_types=1);

namespace App\Exceptions;
use Exception;

class AuthorArticlesNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Authors articles not found', 404);
    }
}