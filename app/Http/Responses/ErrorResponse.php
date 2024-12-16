<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

class ErrorResponse implements Responsable
{
    private string $timestamp;
    private int $statusCode;
    private string $message;
    private ?array $errors;
    private string $path;

    public function __construct(
        int $statusCode,
        string $message,
        ?array $errors = null,
        ?string $path = null
    ) {
        $this->statusCode = $statusCode;
        $this->timestamp = now()->toIso8601String();
        $this->message = $message;
        $this->errors = $errors;
        $this->path = $path ?? '/' . request()->path();
    }

    /**
     * Convert the error response to an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'timestamp' => $this->timestamp,
            'message' => $this->message,
            'errors' => $this->errors,
            'path' => $this->path,
        ], $this->statusCode);
    }
}
