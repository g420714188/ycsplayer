<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException as Exception;

class CustomException extends Exception
{
    public function __construct(int $statusCode, string $message)
    {
        parent::__construct($statusCode,$message);
    }
}
