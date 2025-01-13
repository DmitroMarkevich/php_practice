<?php

namespace App\Mail;

use App\Enums\EmailType;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public EmailType $emailType,
        public array $mailData
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailType->getSubject(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->emailType->getTemplateName(),
            with: $this->mailData,
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
