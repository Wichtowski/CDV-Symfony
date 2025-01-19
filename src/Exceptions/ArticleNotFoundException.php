<?php
declare(strict_types=1);

namespace App\Exceptions;
use Exception;

class ArticleNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Article not found', 404);
    }
}