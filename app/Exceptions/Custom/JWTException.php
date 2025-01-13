<?php

namespace App\Exceptions\Custom;

use App\Constants\Message;
use Symfony\Component\HttpFoundation\Response;

class JWTException extends BaseException
{
    public function __construct(string $message = Message::AuthErrors['UNAUTHORIZED_ACTION'])
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED, $message);
    }
}
