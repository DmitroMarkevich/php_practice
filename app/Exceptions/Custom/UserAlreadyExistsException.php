<?php

namespace App\Exceptions\Custom;

use App\Constants\Message;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyExistsException extends BaseException
{
    public function __construct(string $message = Message::UserErrors['USER_ALREADY_EXISTS'])
    {
        parent::__construct(Response::HTTP_CONFLICT, $message);
    }
}
