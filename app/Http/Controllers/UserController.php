<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\UserVerificationService;
use Illuminate\Validation\ValidationException;
use App\Exceptions\Custom\EmailVerifiedException;
use App\Exceptions\Custom\UserNotFoundException;
use App\Exceptions\Custom\VerificationTokenException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UserController extends BaseController
{
    private UserVerificationService $userVerificationService;

    public function __construct(UserVerificationService $userVerificationService)
    {
        $this->userVerificationService = $userVerificationService;
    }

    /**
     * Verify a user's email using a verification token.
     *
     * @param string $token The verification token provided by the user.
     * @return Response|JsonResponse An empty response with HTTP 200 on success.
     * @throws ValidationException If the token validation fails.
     * @throws VerificationTokenException If the token is invalid or expired.
     */
    public function verifyEmail(string $token): Response|JsonResponse
    {
        $this->validateRequest(['token' => $token], ['token' => 'required|uuid']);

        $this->userVerificationService->verifyEmail($token);

        return response()->noContent(HttpResponse::HTTP_OK);
    }

    /**
     * Resend the email verification link to the user.
     *
     * @param string $email The email address of the user.
     * @return Response|JsonResponse An empty response with HTTP 200 on success.
     * @throws ValidationException If the email validation fails.
     * @throws EmailVerifiedException If the user's email is already verified.
     * @throws UserNotFoundException If the user with the given email does not exist.
     */
    public function resendVerificationEmail(string $email): Response|JsonResponse
    {
        $this->validateRequest(['email' => $email], ['email' => 'required|email']);

        $this->userVerificationService->resendVerificationEmail($email);

        return response()->noContent(HttpResponse::HTTP_OK);
    }
}
