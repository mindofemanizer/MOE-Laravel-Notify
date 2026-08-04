<?php

declare(strict_types=1);

namespace Moe\Notify\Contracts;

use Moe\Notify\Models\Notification;

interface NotifierInterface
{
    public function send(mixed $notifiable, Notification $notification, array $channels = []): void;

    public function sendNow(mixed $notifiable, Notification $notification, array $channels = []): array;

    public function channel(string $name): NotificationChannelInterface;
}
