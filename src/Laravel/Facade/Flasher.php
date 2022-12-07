<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Facade;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Prime\Stamp\StampInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static NotificationBuilder addSuccess(string $message, array $options = array())
 * @method static NotificationBuilder addError(string $message, array $options = array())
 * @method static NotificationBuilder addWarning(string $message, array $options = array())
 * @method static NotificationBuilder addInfo(string $message, array $options = array())
 * @method static NotificationBuilder addFlash(NotificationInterface|string $type, string $message = null, array $options = array())
 * @method static NotificationBuilder flash(StampInterface[] $stamps = array())
 * @method static NotificationBuilder type(string $type, string $message = null, array $options = array())
 * @method static NotificationBuilder message(string $message)
 * @method static NotificationBuilder options(array $options, bool $merge = true)
 * @method static NotificationBuilder option(string $name, $value)
 * @method static NotificationBuilder success(string $message = null, array $options = array())
 * @method static NotificationBuilder error(string $message = null, array $options = array())
 * @method static NotificationBuilder info(string $message = null, array $options = array())
 * @method static NotificationBuilder warning(string $message = null, array $options = array())
 * @method static NotificationBuilder priority(int $priority)
 * @method static NotificationBuilder hops(int $amount)
 * @method static NotificationBuilder keep()
 * @method static NotificationBuilder delay(int $delay)
 * @method static NotificationBuilder now()
 * @method static NotificationBuilder with(StampInterface[] $stamps = array())
 * @method static NotificationBuilder withStamp(StampInterface $stamp)
 * @method static NotificationBuilder handler(string $handler)
 * @method static Envelope            getEnvelope()
 */
class Flasher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flasher';
    }
}
