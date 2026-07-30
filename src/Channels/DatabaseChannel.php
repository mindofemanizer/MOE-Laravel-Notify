<?php

declare(strict_types=1);

namespace MOE\Notify\Channels;

use MOE\Notify\Contracts\NotificationChannelInterface;
use MOE\Notify\Models\Notification;

class DatabaseChannel implements NotificationChannelInterface
{
    public function __construct(
        protected array $config = [],
    ) {}

    public function send(mixed $notifiable, Notification $notification): bool
    {
        $notifiable->notifications()->save($notification);

        return true;
    }

    public function driver(): string
    {
        return 'database';
    }

    public function name(): string
    {
        return 'database';
    }
}
