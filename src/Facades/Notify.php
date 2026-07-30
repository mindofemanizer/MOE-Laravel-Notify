<?php

declare(strict_types=1);

namespace MOE\Notify\Facades;

use Illuminate\Support\Facades\Facade;
use MOE\Notify\Contracts\NotifierInterface;

/**
 * @method static void send(mixed $notifiable, \MOE\Notify\Models\Notification $notification, array $channels = [])
 * @method static array sendNow(mixed $notifiable, \MOE\Notify\Models\Notification $notification, array $channels = [])
 * @method static \MOE\Notify\Contracts\NotificationChannelInterface channel(string $name)
 */
class Notify extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return NotifierInterface::class;
    }
}
