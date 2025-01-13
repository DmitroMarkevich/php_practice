<?php

namespace App\Exceptions\Custom;

use App\Constants\Message;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends BaseException
{
    public function __construct(string $message = Message::UserErrors['USER_NOT_FOUND'])
    {
        parent::__construct(Response::HTTP_NOT_FOUND, $message);
    }
}
