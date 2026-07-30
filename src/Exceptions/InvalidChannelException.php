<?php

declare(strict_types=1);

namespace MOE\Notify\Exceptions;

use InvalidArgumentException;

class InvalidChannelException extends InvalidArgumentException
{
    public function __construct(string $channel)
    {
        parent::__construct("Notification channel [{$channel}] is not supported.");
    }
}
