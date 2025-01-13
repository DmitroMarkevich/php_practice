<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Responses\AuthTokenResponse;
use App\Http\Responses\SocialAuthResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Exceptions\Custom\InvalidCredentialsException;
use App\Exceptions\Custom\UserAlreadyExistsException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController extends BaseController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle user registration.
     *
     * @param UserRequest $request The validated request containing user data.
     * @return Response An HTTP response indicating the resource was created.
     * @throws UserAlreadyExistsException If a user with the same email already exists.
     */
    public function register(UserRequest $request): Response
    {
        $validatedData = $request->validated();

        $this->authService->register(new User($validatedData));

        return response()->noContent(HttpResponse::HTTP_CREATED);
    }

    /**
     * Handle user login and return authentication tokens.
     *
     * @param LoginRequest $request The validated login request.
     * @return AuthTokenResponse A response containing access and refresh tokens.
     * @throws InvalidCredentialsException If authentication fails.
     */
    public function login(LoginRequest $request): AuthTokenResponse
    {
        $credentials = $request->validated();

        $user = $this->authService->authenticate($credentials);

        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = JWTAuth::setToken($accessToken)->refresh();

        return new AuthTokenResponse($accessToken, $refreshToken);
    }

    /**
     * Log the user out and invalidate the token.
     *
     * @return Response A response indicating the user has been logged out.
     */
    public function logout(): Response
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->noContent(HttpResponse::HTTP_NO_CONTENT);
    }

    public function handleProviderCallback(string $provider): SocialAuthResponse
    {
        $socialiteUser = Socialite::driver($provider)->stateless()->user();

        return new SocialAuthResponse(
            name: $socialiteUser->getName(),
            email: $socialiteUser->getEmail(),
            avatar: $socialiteUser->getAvatar(),
            provider: $provider
        );
    }
}
