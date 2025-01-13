<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Exceptions\Custom\InvalidCredentialsException;
use App\Exceptions\Custom\UserAlreadyExistsException;

class AuthService
{
    private UserService $userService;

    private EmailService $emailService;

    private UserVerificationService $userVerificationService;

    /**
     * @param UserService $userService
     * @param UserVerificationService $userVerificationService
     * @param EmailService $emailService
     */
    public function __construct(
        UserService $userService,
        UserVerificationService $userVerificationService,
        EmailService $emailService
    ) {
        $this->userService = $userService;
        $this->emailService = $emailService;
        $this->userVerificationService = $userVerificationService;
    }

    /**
     * Store a new user in the database.
     *
     * @param User $user The user instance to be stored.
     * @return void This method performs a database transaction and sends an email but does not return any value.
     * @throws UserAlreadyExistsException If a user with the same email already exists.
     */
    public function register(User $user): void
    {
        $email = $user->email;

        if ($this->userService->isUserExistByEmail($email)) {
            throw new UserAlreadyExistsException('A user with this email already exists.');
        }

        DB::transaction(function () use ($user, $email) {
            $user->save();

            $user->assignRole('admin');

            $this->userVerificationService->generateVerificationToken($user);
        });

        $this->emailService->sendWelcomeEmail($email);
    }

    /**
     * Authenticate a user based on credentials.
     *
     * @param array $credentials The user's credentials (email and password).
     * @return Authenticatable The authenticated user instance.
     * @throws InvalidCredentialsException If authentication fails.
     */
    public function authenticate(array $credentials): Authenticatable
    {
        if (!Auth::attempt($credentials)) {
            throw new InvalidCredentialsException();
        }

        return $this->getAuthenticatedUser();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable The authenticated user instance.
     */
    public function getAuthenticatedUser(): Authenticatable
    {
        return Auth::user();
    }
}
