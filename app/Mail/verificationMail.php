<?php

namespace AppMail;

use IlluminateBusQueueable;
use IlluminateContractsQueueShouldQueue;
use IlluminateMailMailable;
use IlluminateMailMailablesContent;
use IlluminateMailMailablesEnvelope;
use IlluminateQueueSerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ایمیل فعالسازی حساب کاربری',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, IlluminateMailMailablesAttachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
