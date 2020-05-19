<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserArtificiallyCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $email;
    private $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Account created')
            ->line('An administrator has created a user account just for you.')
            ->line("Your email: $this->email")
            ->line("Your password: $this->password")
            ->action('Login to Arbify', route('login'));
    }
}
