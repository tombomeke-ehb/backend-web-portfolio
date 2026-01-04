<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $messageModel)
    {
    }

    public function envelope(): Envelope
    {
        $subject = $this->messageModel->subject
            ? 'Re: ' . $this->messageModel->subject
            : 'Re: Your message';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.reply-user',
            with: [
                'messageModel' => $this->messageModel,
            ],
        );
    }
}
