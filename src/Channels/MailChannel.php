<?php

declare(strict_types=1);

namespace MOE\Notify\Channels;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use MOE\Notify\Contracts\NotificationChannelInterface;
use MOE\Notify\Models\Notification;

class MailChannel implements NotificationChannelInterface
{
    public function __construct(
        protected array $config = [],
    ) {}

    public function send(mixed $notifiable, Notification $notification): bool
    {
        if (! $email = $this->getEmail($notifiable)) {
            return false;
        }

        Mail::raw($notification->body, function ($message) use ($email, $notification) {
            $message->to($email)
                ->subject($notification->subject);
        });

        return true;
    }

    public function driver(): string
    {
        return $this->config['driver'] ?? 'log';
    }

    public function name(): string
    {
        return 'mail';
    }

    protected function getEmail(mixed $notifiable): ?string
    {
        if (is_string($notifiable)) {
            return $notifiable;
        }

        if (method_exists($notifiable, 'routeNotificationForMail')) {
            return $notifiable->routeNotificationForMail($this);
        }

        return $notifiable->email ?? $notifiable->mail ?? null;
    }
}
