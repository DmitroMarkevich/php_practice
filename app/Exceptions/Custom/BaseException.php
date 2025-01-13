<?php

namespace App\Exceptions\Custom;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseException extends Exception
{
    protected $message;

    protected int $statusCode;

    public function __construct(int $statusCode, string $message)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        parent::__construct($message);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error("Exception: {$this->getMessage()} | Code: $this->statusCode");
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(): ErrorResponse
    {
        $messageCode = Response::$statusTexts[$this->statusCode];

        return new ErrorResponse($this->statusCode, $messageCode, $this->getMessage());
    }
}
