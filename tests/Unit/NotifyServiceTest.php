<?php

declare(strict_types=1);

use Moe\Notify\Contracts\NotifierInterface;
use Moe\Notify\Facades\Notify;
use Moe\Notify\Models\Notification;
use Moe\Notify\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->service = app(NotifierInterface::class);
});

it('resolves notifier service from container', function () {
    expect($this->service)->toBeInstanceOf(NotifierInterface::class);
});

it('facade delegates to service', function () {
    $channel = Notify::channel('mail');

    expect($channel->name())->toBe('mail');
});

it('channel manager returns registered channels', function () {
    $channel = $this->service->channel('mail');

    expect($channel->name())->toBe('mail');
    expect($channel->driver())->toBe('log');
});

it('send does not throw for invalid notifiable', function () {
    $notification = new Notification([
        'type' => 'test',
        'subject' => 'Hello',
        'body' => 'Test body',
    ]);

    $this->service->send('user@example.com', $notification, ['mail']);

    expect(true)->toBeTrue();
});

it('sendNow returns results per channel', function () {
    $notification = new Notification([
        'type' => 'test',
        'subject' => 'Hello',
        'body' => 'Test body',
    ]);

    $results = $this->service->sendNow('user@example.com', $notification, ['mail']);

    expect($results)->toBeArray();
    expect($results)->toHaveKey('mail');
    expect($results['mail'])->toBeTrue();
});
