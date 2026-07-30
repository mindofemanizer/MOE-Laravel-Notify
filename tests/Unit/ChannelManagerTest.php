<?php

declare(strict_types=1);

use MOE\Notify\Channels\MailChannel;
use MOE\Notify\Contracts\NotificationChannelInterface;
use MOE\Notify\Services\ChannelManager;
use MOE\Notify\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->manager = new ChannelManager;
});

it('resolves built-in mail channel', function () {
    $channel = $this->manager->get('mail');

    expect($channel)->toBeInstanceOf(NotificationChannelInterface::class);
    expect($channel->name())->toBe('mail');
});

it('resolves built-in sms channel', function () {
    $channel = $this->manager->get('sms');

    expect($channel)->toBeInstanceOf(NotificationChannelInterface::class);
    expect($channel->name())->toBe('sms');
});

it('resolves built-in whatsapp channel', function () {
    $channel = $this->manager->get('whatsapp');

    expect($channel)->toBeInstanceOf(NotificationChannelInterface::class);
    expect($channel->name())->toBe('whatsapp');
});

it('resolves built-in database channel', function () {
    $channel = $this->manager->get('database');

    expect($channel)->toBeInstanceOf(NotificationChannelInterface::class);
    expect($channel->name())->toBe('database');
});

it('registers custom channel instance', function () {
    $custom = new MailChannel;
    $this->manager->register('custom-mail', $custom);

    expect($this->manager->get('custom-mail'))->toBe($custom);
});

it('registers custom channel class', function () {
    $this->manager->register('dynamic-mail', MailChannel::class);

    expect($this->manager->get('dynamic-mail'))->toBeInstanceOf(MailChannel::class);
});

it('throws for unknown channel', function () {
    $this->manager->get('unknown-channel');
})->throws(InvalidArgumentException::class);

it('lists available channels', function () {
    $channels = $this->manager->channels();

    expect($channels)->toContain('mail', 'sms', 'whatsapp', 'database');
});
