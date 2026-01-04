<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminContactReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $messageModel)
    {
    }

    public function envelope(): Envelope
    {
        $subject = $this->messageModel->subject
            ? 'Portfolio Contact: ' . $this->messageModel->subject
            : 'Portfolio Contact message';

        return new Envelope(
            subject: $subject,
            replyTo: [$this->messageModel->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.received-admin',
            with: [
                'messageModel' => $this->messageModel,
            ],
        );
    }
}
