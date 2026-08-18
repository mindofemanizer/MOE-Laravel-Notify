<?php

declare(strict_types=1);

namespace Moe\Notify;

use Illuminate\Support\ServiceProvider;
use Moe\Notify\Contracts\NotifierInterface;
use Moe\Notify\Services\NotifyService;
use Moe\Notify\Services\ChannelManager;

class NotifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/moe-notify.php', 'moe-notify');

        $this->app->singleton(ChannelManager::class, fn () => new ChannelManager);
        $this->app->singleton(NotifierInterface::class, fn ($app) => new NotifyService(
            $app->make(ChannelManager::class),
            $app->make('config')->get('moe-notify'),
        ));
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/moe-notify.php' => config_path('moe-notify.php'),
            ], 'moe-notify-config');
        }
    }
}
