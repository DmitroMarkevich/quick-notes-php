<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Tests\Foundation\CustomException;

class UserAlreadyExistsException extends CustomException
{
    public function __construct($message = "User already exists", $code = 409)
    {
        parent::__construct($message, $code);
    }
}
