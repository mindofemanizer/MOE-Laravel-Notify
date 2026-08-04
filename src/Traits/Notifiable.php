<?php

declare(strict_types=1);

namespace Moe\Notify\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Moe\Notify\Models\Notification;

trait Notifiable
{
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function unreadNotifications(): MorphMany
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function markAsRead(?string $id = null): void
    {
        if ($id) {
            $this->notifications()->whereKey($id)->update(['read_at' => now()]);
        } else {
            $this->unreadNotifications()->update(['read_at' => now()]);
        }
    }

    public function routeNotificationForMail(?object $channel = null): ?string
    {
        return $this->email ?? null;
    }

    public function routeNotificationForSms(?object $channel = null): ?string
    {
        return $this->phone ?? $this->mobile ?? null;
    }

    public function routeNotificationForWhatsapp(?object $channel = null): ?string
    {
        return $this->phone ?? $this->mobile ?? null;
    }
}
