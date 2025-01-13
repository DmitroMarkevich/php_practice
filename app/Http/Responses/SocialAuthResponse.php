<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\JsonResponse;

class SocialAuthResponse implements Responsable
{
    public function __construct(
        public string $name,
        public string $email,
        public string $avatar,
        public string $provider
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'provider' => $this->provider
        ]);
    }
}
