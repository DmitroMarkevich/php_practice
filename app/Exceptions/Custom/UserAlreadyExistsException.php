<?php

namespace App\Exceptions\Custom;

use Symfony\Component\HttpFoundation\Response;

class UserAlreadyExistsException extends BaseException
{
    public function __construct(string $message = 'User already exists')
    {
        parent::__construct(Response::HTTP_CONFLICT, $message);
    }
}
