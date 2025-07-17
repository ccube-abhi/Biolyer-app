<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CustomResetPassword extends Notification
{
    public string $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        try {
            $resetUrl = config('app.api_url') . '/api/v1/reset-password/' . $this->token . '?email=' . urlencode($notifiable->email);

            return (new MailMessage())
                ->subject(__('messages.reset_your_password'))
                ->view('emails.reset-password', [
                    'url' => $resetUrl,
                    'user' => $notifiable,
                ]);
        } catch (\Throwable $e) {
            Log::error('Password email error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // rethrow so Laravel sees the error too
        }
    }
}
