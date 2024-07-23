<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EOSCMailer extends Mailable
{
    use Queueable, SerializesModels;

    public array $mailData;

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * Create a new message instance.
     */
    public function __construct(array $mailData)
    {
        $this->mailData = $mailData;
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->mailData['recipient'] ?? env('MAIL_FROM_ADDRESS'),
            subject: 'E O S C Mailer: '.$this->mailData['subject'] ?? '',
        );
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->mailData['view'] ?? 'emails.feedback',
        );
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
