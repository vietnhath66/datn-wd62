<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    public function __construct($user)
    {
        $this->user = $user;

        $this->verificationUrl = URL::temporarySignedRoute(
            'client.verification.verify', 
            Carbon::now()->addMinutes(60), 
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác thực địa chỉ Email của bạn',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.auth.verify-email',
            with: [
                'name' => $this->user->name, 
                'verificationUrl' => $this->verificationUrl, 
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
