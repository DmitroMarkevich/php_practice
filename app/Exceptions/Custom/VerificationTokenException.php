<?php

namespace App\Exceptions\Custom;

use App\Constants\Message;
use Symfony\Component\HttpFoundation\Response;

class VerificationTokenException extends BaseException
{
    public function __construct(string $message = Message::UserErrors['USER_INVALID_VERIFICATION_TOKEN'])
    {
        parent::__construct(Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }
}
