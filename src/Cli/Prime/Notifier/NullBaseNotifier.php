<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime\Notifier;

final class NullBaseNotifier extends BaseNotifier
{
    public function send($notification): void
    {
    }

    public function isSupported(): bool
    {
        return false;
    }

    public function getBinary(): string
    {
        return '';
    }
}
