<?php

declare(strict_types=1);

namespace MOE\Notify\Contracts;

interface NotificationTemplateInterface
{
    public function render(string $templateKey, array $data = []): string;

    public function compile(string $content, array $data = []): string;
}
