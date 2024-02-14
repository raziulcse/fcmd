<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountUnsuspended extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public User $user)
    {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Account Suspension Removed'))
            ->greeting(__('Hello :name,', ['name' => $this->user->name]))
            ->line(__('Suspension has been removed. Your account is now active.'))
            ->line(__('You can now log into your account.'))
            ->action(__('Log in'), route('login'))
            ->line(__('Thank you for staying with us.'));
    }
}
