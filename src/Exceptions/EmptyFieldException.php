<?php
declare(strict_types=1);

namespace App\Exceptions;
use Exception;

class EmptyFieldException extends \Exception
{
    public function __construct(string $fieldName)
    {
        parent::__construct($fieldName, 400);
    }
}