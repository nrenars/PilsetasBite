<?php

namespace App\Mail;

use App\Models\Lietotajs;
use App\Models\Parkapums;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LietotajsNoblokets extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Lietotajs $lietotajs,
        public Parkapums $parkapums,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jūsu konts ir nobloķēts — PilsetasBite',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.noblokets',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
