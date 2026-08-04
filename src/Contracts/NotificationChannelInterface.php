<?php

declare(strict_types=1);

namespace Moe\Notify\Contracts;

use Moe\Notify\Models\Notification;

interface NotificationChannelInterface
{
    public function send(mixed $notifiable, Notification $notification): bool;

    public function driver(): string;

    public function name(): string;
}
