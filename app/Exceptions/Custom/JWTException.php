<?php

namespace App\Exceptions\Custom;

use Symfony\Component\HttpFoundation\Response;

class JWTException extends BaseException
{
    public function __construct(string $message = 'Conflict with JWT token')
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED, $message);
    }
}
