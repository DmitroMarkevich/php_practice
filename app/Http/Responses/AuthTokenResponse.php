<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

readonly class AuthTokenResponse implements Responsable
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'access_token' => $this->accessToken,
            'refresh_token' => $this->refreshToken
        ]);
    }
}
