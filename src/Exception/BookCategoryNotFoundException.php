<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class BookCategoryNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct(message: 'book category not found', code: Response::HTTP_NOT_FOUND);
    }
}
