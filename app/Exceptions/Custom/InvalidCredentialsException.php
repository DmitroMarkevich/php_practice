<?php

namespace App\Exceptions\Custom;

use App\Constants\Message;
use Symfony\Component\HttpFoundation\Response;

class InvalidCredentialsException extends BaseException
{
    public function __construct(string $message = Message::UserErrors['USER_CREDENTIALS_INVALID'])
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED, $message);
    }
}
