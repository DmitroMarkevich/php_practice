<?php

namespace App\Exceptions\Custom;

use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends BaseException
{
    public function __construct(string $message = 'User not found')
    {
        parent::__construct(Response::HTTP_NOT_FOUND, $message);
    }
}
