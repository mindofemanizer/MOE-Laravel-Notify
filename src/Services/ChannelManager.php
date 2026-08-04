<?php

declare(strict_types=1);

namespace Moe\Notify\Services;

use InvalidArgumentException;
use Moe\Notify\Channels\DatabaseChannel;
use Moe\Notify\Channels\MailChannel;
use Moe\Notify\Channels\SmsChannel;
use Moe\Notify\Channels\WhatsappChannel;
use Moe\Notify\Contracts\NotificationChannelInterface;

class ChannelManager
{
    protected array $channels = [];

    protected array $drivers = [
        'mail' => MailChannel::class,
        'sms' => SmsChannel::class,
        'whatsapp' => WhatsappChannel::class,
        'database' => DatabaseChannel::class,
    ];

    public function register(string $name, string|NotificationChannelInterface $channel, array $config = []): void
    {
        if (is_string($channel)) {
            $channel = new $channel($config);
        }

        $this->channels[$name] = $channel;
    }

    public function get(string $name, array $config = []): NotificationChannelInterface
    {
        if (isset($this->channels[$name])) {
            return $this->channels[$name];
        }

        if (! isset($this->drivers[$name])) {
            throw new InvalidArgumentException("Channel [{$name}] is not registered.");
        }

        $class = $this->drivers[$name];

        return $this->channels[$name] = new $class($config);
    }

    public function extend(string $name, callable $resolver): void
    {
        $this->channels[$name] = $resolver;
    }

    public function channels(): array
    {
        return array_keys($this->drivers);
    }
}
