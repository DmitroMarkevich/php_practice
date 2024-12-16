<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Http\Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;


class UserNotFoundException extends Exception
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
        return new ErrorResponse(Response::HTTP_NOT_FOUND, $this->getMessage());
    }
}
