<?php

namespace App\Services;

use App\Constants\Message;
use App\Exceptions\Custom\UserNotFoundException;
use App\Models\User;
use App\Models\EmailVerificationToken;
use App\Exceptions\Custom\EmailVerifiedException;
use App\Exceptions\Custom\VerificationTokenException;

class UserVerificationService
{
    private UserService $userService;

    private EmailService $emailService;

    /**
     * @param UserService $userService
     * @param EmailService $emailService
     */
    public function __construct(UserService $userService, EmailService $emailService)
    {
        $this->userService = $userService;
        $this->emailService = $emailService;
    }

    /**
     * Generate a verification token for the given user.
     *
     * @param User $user
     * @return EmailVerificationToken
     * @throws EmailVerifiedException
     */
    public function generateVerificationToken(User $user): EmailVerificationToken
    {
        if ($user->email_verified) {
            throw new EmailVerifiedException('The email is already verified.');
        }

        return EmailVerificationToken::create(['user_id' => $user->id]);
    }

    /**
     * Verify a user's email using the provided token.
     *
     * @param string $token
     * @throws VerificationTokenException
     */
    public function verifyEmail(string $token): void
    {
        $emailVerificationToken = EmailVerificationToken::where('token', $token)->first();

        if (!$emailVerificationToken) {
            throw new VerificationTokenException('The verification token is invalid.');
        }

        if ($emailVerificationToken->isExpired()) {
            throw new VerificationTokenException('The verification token has expired.');
        }

        $user = $emailVerificationToken->user;

        if ($user->email_verified) {
            throw new VerificationTokenException(Message::UserErrors['USER_EMAIL_IS_VERIFIED']);
        }

        $user->update(['email_verified' => true]);
    }

    /**
     * Resend the verification email to the specified email address.
     *
     * @param string $email The email address to resend the verification email to.
     * @throws UserNotFoundException If a user with the specified email does not exist in the system.
     * @throws EmailVerifiedException If the user's email is already verified.
     */
    public function resendVerificationEmail(string $email): void
    {
        $user = $this->userService->getUserByEmail($email);

        if ($user->email_verified) {
            throw new EmailVerifiedException('The email is already verified.');
        }

        $token = $this->generateVerificationToken($user);

        $this->emailService->sendVerificationEmail($user->email, $token->token);
    }
}
