<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountSuspended extends Notification implements ShouldQueue
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
        if ($this->user->isBanned()) {
            return $this->bannedMessage();
        }

        return (new MailMessage)
            ->subject(__('Account suspended'))
            ->line(__('Your account has been suspended.'))
            ->line(__('Reason: **:reason**', ['reason' => $this->user->suspension_reason]))
            ->line(__('Suspension will end on: :date', ['date' => $this->user->suspention_ends_at]))
            ->line(__('If you believe this is a mistake, please contact us.'));
    }

    private function bannedMessage(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Account banned'))
            ->line(__('Your account has been banned.'))
            ->line(__('Reason: **:reason**', ['reason' => $this->user->suspension_reason]))
            ->line(__('If you believe this is a mistake, You can contact us describing the reason.'))
            ->line(__('Thank you for your understanding.'));
    }
}
