<?php

declare(strict_types=1);

namespace Moe\Notify\Facades;

use Illuminate\Support\Facades\Facade;
use Moe\Notify\Contracts\NotifierInterface;

/**
 * @method static void send(mixed $notifiable, \Moe\Notify\Models\Notification $notification, array $channels = [])
 * @method static array sendNow(mixed $notifiable, \Moe\Notify\Models\Notification $notification, array $channels = [])
 * @method static \Moe\Notify\Contracts\NotificationChannelInterface channel(string $name)
 */
class Notify extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return NotifierInterface::class;
    }
}
