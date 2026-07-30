<?php

declare(strict_types=1);

namespace MOE\Notify;

use Illuminate\Support\ServiceProvider;
use MOE\Notify\Contracts\NotifierInterface;
use MOE\Notify\Services\NotifyService;
use MOE\Notify\Services\ChannelManager;

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
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/moe-notify.php' => config_path('moe-notify.php'),
            ], 'moe-notify-config');

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
    }
}
