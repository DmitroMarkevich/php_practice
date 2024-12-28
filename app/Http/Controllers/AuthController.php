<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Responses\AuthTokenResponse;
use App\Exceptions\Custom\InvalidCredentialsException;
use App\Exceptions\Custom\UserAlreadyExistsException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the request to store a new user resource.
     *
     * @param UserRequest $request The validated user request containing input data.
     * @return Response A response indicating the resource was created.
     * @throws UserAlreadyExistsException If a user with the same unique data already exists.
     */
    public function register(UserRequest $request): Response
    {
        $validated = $request->validated();

        $this->userService->storeUser(new User($validated));

        return response()->noContent(ResponseAlias::HTTP_CREATED);
    }

    /**
     * Handle user login and return authentication tokens.
     *
     * @param LoginRequest $request The validated login request.
     * @return AuthTokenResponse The authentication tokens (access and refresh).
     * @throws InvalidCredentialsException If the provided credentials are invalid.
     */
    public function login(LoginRequest $request): AuthTokenResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            throw new InvalidCredentialsException();
        }

        $accessToken = JWTAuth::fromUser(Auth::user());
        $refreshToken = JWTAuth::setToken($accessToken)->refresh();

        return new AuthTokenResponse($accessToken, $refreshToken);
    }
}
