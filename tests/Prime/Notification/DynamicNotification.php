<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Notification;

final class DynamicNotification extends \Flasher\Prime\Notification\Notification
{
    public function foo(): string
    {
        return 'foobar';
    }
}
