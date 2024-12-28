<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

readonly class ErrorResponse implements Responsable
{
    private array $errors;
    private string $timestamp;
    private string $path;

    public function __construct(
        private int $statusCode,
        private string $message,
        string $errors,
    ) {
        $this->errors = explode(';', $errors);;
        $this->timestamp = now()->toIso8601String();
        $this->path = '/' . request()->path();
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
