<?php

namespace App\Services;

use App\Enums\EmailType;
use App\Jobs\SendEmailJob;

class EmailService
{
    /**
     * Send an email via the email job dispatcher.
     *
     * @param EmailType $emailType
     * @param array $emailData
     * @param string $recipientEmail
     * @return void
     */
    public function sendEmail(EmailType $emailType, array $emailData, string $recipientEmail): void
    {
        SendEmailJob::dispatch($emailType, $emailData, $recipientEmail);
    }

    /**
     * Send verification email.
     *
     * @param string $email
     * @param string $token
     * @return void
     */
    public function sendVerificationEmail(string $email, string $token): void
    {
        $this->sendEmail(EmailType::EMAIL_VERIFICATION, ['token' => $token], $email);
    }

    /**
     * Send welcome email.
     *
     * @param string $email
     * @return void
     */
    public function sendWelcomeEmail(string $email): void
    {
        $this->sendEmail(EmailType::WELCOME_EMAIL, [], $email);
    }
}
