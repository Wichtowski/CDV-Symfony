<?php
declare(strict_types=1);

namespace App\Exceptions;
use Exception;

class AuthorNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Author not found', 404, $previous);
    }
}