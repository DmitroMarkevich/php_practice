<?php

namespace App\Jobs;

use App\Mail\Email;
use App\Enums\EmailType;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public EmailType $emailType,
        public array $mailData,
        public string $recipientEmail
    ) {}

    /**
     * Execute the job to send the email.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->sendEmail();
    }

    /**
     * Send the email using the appropriate mail data and type.
     *
     * @return void
     */
    private function sendEmail(): void
    {
        Mail::to($this->recipientEmail)->send(new Email($this->emailType, $this->mailData));
    }
}
