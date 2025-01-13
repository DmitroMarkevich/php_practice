<?php

namespace App\Exceptions\Custom;

use App\Constants\Message;
use Symfony\Component\HttpFoundation\Response;

class EmailVerifiedException extends BaseException
{
    public function __construct(string $message = Message::UserErrors['USER_EMAIL_IS_VERIFIED'])
    {
        parent::__construct(Response::HTTP_CONFLICT, $message);
    }
}
