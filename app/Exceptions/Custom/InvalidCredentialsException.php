<?php

namespace App\Exceptions\Custom;

use Symfony\Component\HttpFoundation\Response;

class InvalidCredentialsException extends BaseException
{
    public function __construct(string $message = 'Invalid credentials provided')
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED, $message);
    }
}
