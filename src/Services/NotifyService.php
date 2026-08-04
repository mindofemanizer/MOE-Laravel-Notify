<?php

declare(strict_types=1);

namespace Moe\Notify\Services;

use Illuminate\Support\Facades\Log;
use Moe\Notify\Contracts\NotifierInterface;
use Moe\Notify\Contracts\NotificationChannelInterface;
use Moe\Notify\Exceptions\NotificationFailedException;
use Moe\Notify\Models\Notification;

class NotifyService implements NotifierInterface
{
    protected array $config;

    public function __construct(
        protected ChannelManager $manager,
        array $config = [],
    ) {
        $this->config = $config;
    }

    public function send(mixed $notifiable, Notification $notification, array $channels = []): void
    {
        $channels = $channels ?: [$this->config['default_channel'] ?? 'mail'];

        foreach ($channels as $channelName) {
            $channel = $this->manager->get($channelName, $this->config['channels'][$channelName] ?? []);

            try {
                $success = $channel->send($notifiable, $notification);

                if ($this->config['logging']['enabled'] ?? true) {
                    $this->log($notification, $channelName, $success);
                }
            } catch (\Throwable $e) {
                Log::error("[MOE Notify] Failed on channel {$channelName}: {$e->getMessage()}");

                if ($this->config['logging']['enabled'] ?? true) {
                    $this->log($notification, $channelName, false, $e->getMessage());
                }
            }
        }
    }

    public function sendNow(mixed $notifiable, Notification $notification, array $channels = []): array
    {
        $results = [];
        $channels = $channels ?: [$this->config['default_channel'] ?? 'mail'];

        foreach ($channels as $channelName) {
            $channel = $this->manager->get($channelName, $this->config['channels'][$channelName] ?? []);
            $results[$channelName] = $channel->send($notifiable, $notification);
        }

        return $results;
    }

    public function channel(string $name): NotificationChannelInterface
    {
        return $this->manager->get($name, $this->config['channels'][$name] ?? []);
    }

    protected function log(Notification $notification, string $channel, bool $success, ?string $error = null): void
    {
        Log::info("[MOE Notify] {$channel}: " . ($success ? 'sent' : 'failed'), [
            'notification_id' => $notification->getKey(),
            'channel' => $channel,
            'error' => $error,
        ]);
    }
}
