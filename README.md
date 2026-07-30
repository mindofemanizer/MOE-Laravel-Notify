# MOE Laravel Notify

Package notifikasi multichannel untuk Laravel — email, SMS, WhatsApp, in-app, dan push.

## Persyaratan

- PHP `^8.2`
- Laravel `^11 | ^12 | ^13`

## Instalasi

```bash
composer require moe/laravel-notify
php artisan vendor:publish --provider="MOE\\Notify\\NotifyServiceProvider" --tag="moe-notify-config"
php artisan migrate
```

## Mulai Cepat

### 1. Kirim notifikasi

```php
use MOE\Notify\Facades\Notify;
use MOE\Notify\Models\Notification;

$notif = new Notification([
    'type' => 'welcome',
    'subject' => 'Selamat Datang',
    'body' => 'Halo, terima kasih telah mendaftar!',
]);

Notify::send($user, $notif, ['mail', 'sms']);
```

### 2. Kirim langsung (tanpa antrian)

```php
$results = Notify::sendNow($user, $notif, ['mail', 'whatsapp']);
// ['mail' => true, 'whatsapp' => true]
```

### 3. Gunakan channel tertentu

```php
$channel = Notify::channel('whatsapp');
$channel->send($user, $notif);
```

## Konsep

### Notifiable (Trait)

```php
use MOE\Notify\Traits\Notifiable;

class User extends Model
{
    use Notifiable;

    // Otomatis:
    // - $user->notifications() (relasi morphMany)
    // - $user->unreadNotifications()
    // - $user->markAsRead()
    // - routeNotificationForMail() -> $this->email
    // - routeNotificationForSms() / ForWhatsapp() -> $this->phone
}
```

### Channel

Channel adalah driver pengirim notifikasi. Bawaan:

| Channel    | Driver default | Method routing               |
|------------|---------------|------------------------------|
| `mail`     | `log`         | `routeNotificationForMail()` |
| `sms`      | `log`         | `routeNotificationForSms()`  |
| `whatsapp` | `log`         | `routeNotificationForWhatsapp()` |
| `database` | `database`    | Simpan ke tabel `notifications` |

### Channel Kustom

```php
use MOE\Notify\Contracts\NotificationChannelInterface;

class TelegramChannel implements NotificationChannelInterface
{
    public function send(mixed $notifiable, Notification $notification): bool
    {
        // kirim ke Telegram
        return true;
    }

    public function driver(): string { return 'telegram'; }
    public function name(): string { return 'telegram'; }
}

// Daftarkan
$manager = app(\MOE\Notify\Services\ChannelManager::class);
$manager->register('telegram', TelegramChannel::class);
```

## Konfigurasi

```php
// config/moe-notify.php
return [
    'default_channel' => env('NOTIFY_DEFAULT_CHANNEL', 'mail'),

    'channels' => [
        'mail' => ['driver' => env('NOTIFY_MAIL_DRIVER', 'log')],
        'sms' => ['driver' => env('NOTIFY_SMS_DRIVER', 'log')],
        'whatsapp' => ['driver' => env('NOTIFY_WA_DRIVER', 'log')],
        'database' => ['table' => 'notifications'],
    ],

    'queue' => [
        'enabled' => env('NOTIFY_QUEUE_ENABLED', true),
        'connection' => env('NOTIFY_QUEUE_CONNECTION', 'default'),
        'queue' => env('NOTIFY_QUEUE_NAME', 'notifications'),
    ],

    'retry' => [
        'max_attempts' => 3,
        'backoff_seconds' => 5,
    ],
];
```

## Testing

```bash
composer test
```

## Lisensi

MIT © MOE (MindOfEmanizer)
