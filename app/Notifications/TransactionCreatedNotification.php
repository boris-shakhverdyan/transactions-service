<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionCreatedNotification extends Notification
{
    public function __construct(public Transaction $transaction) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Transaction Created')
            ->line("A transaction of {$this->transaction->amount} {$this->transaction->currency} was created.")
            ->action('View', url('/transactions/' . $this->transaction->uuid));
    }
}
