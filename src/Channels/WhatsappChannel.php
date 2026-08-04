<?php

declare(strict_types=1);

namespace Moe\Notify\Channels;

use Illuminate\Support\Facades\Log;
use Moe\Notify\Contracts\NotificationChannelInterface;
use Moe\Notify\Models\Notification;

class WhatsappChannel implements NotificationChannelInterface
{
    public function __construct(
        protected array $config = [],
    ) {}

    public function send(mixed $notifiable, Notification $notification): bool
    {
        $phone = $this->getPhone($notifiable);

        if (! $phone) {
            return false;
        }

        Log::info("[MOE Notify] WhatsApp sent to {$phone}", [
            'body' => $notification->body,
            'driver' => $this->driver(),
        ]);

        return true;
    }

    public function driver(): string
    {
        return $this->config['driver'] ?? 'log';
    }

    public function name(): string
    {
        return 'whatsapp';
    }

    protected function getPhone(mixed $notifiable): ?string
    {
        if (is_string($notifiable)) {
            return $notifiable;
        }

        if (method_exists($notifiable, 'routeNotificationForWhatsapp')) {
            return $notifiable->routeNotificationForWhatsapp($this);
        }

        return $notifiable->phone ?? $notifiable->mobile ?? null;
    }
}
