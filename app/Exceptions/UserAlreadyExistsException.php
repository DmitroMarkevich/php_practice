<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Http\Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;


class UserAlreadyExistsException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    public function render(Request $request): ErrorResponse
    {
        return new ErrorResponse(Response::HTTP_CONFLICT, $this->getMessage());
    }
}
