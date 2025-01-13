<?php

namespace App\Exceptions\Custom;

use App\Constants\Message;
use Symfony\Component\HttpFoundation\Response;

class RoleAccessDeniedException extends BaseException
{
    public function __construct(string $message = Message::UserErrors['USER_ROLE_FORBIDDEN'])
    {
        parent::__construct(Response::HTTP_FORBIDDEN, $message);
    }
}
