<?php

declare(strict_types=1);

namespace MOE\Notify\Contracts;

use MOE\Notify\Models\Notification;

interface NotificationChannelInterface
{
    public function send(mixed $notifiable, Notification $notification): bool;

    public function driver(): string;

    public function name(): string;
}
