<?php

declare(strict_types=1);

namespace Moe\Notify\Exceptions;

use RuntimeException;

class NotificationFailedException extends RuntimeException
{
    public function __construct(
        string $channel,
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct(
            "Notification failed on channel [{$channel}]: {$message}",
            $code,
            $previous,
        );
    }
}
