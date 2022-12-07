<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Notyf\Laravel\Facade;

use Flasher\Notyf\Prime\NotyfBuilder;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Prime\Stamp\StampInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static NotyfBuilder addSuccess(string $message, array $options = array())
 * @method static NotyfBuilder addError(string $message, array $options = array())
 * @method static NotyfBuilder addWarning(string $message, array $options = array())
 * @method static NotyfBuilder addInfo(string $message, array $options = array())
 * @method static NotyfBuilder addFlash(NotificationInterface|string $type, string $message = null, array $options = array())
 * @method static NotyfBuilder flash(StampInterface[] $stamps = array())
 * @method static NotyfBuilder type(string $type, string $message = null, array $options = array())
 * @method static NotyfBuilder message(string $message)
 * @method static NotyfBuilder options(array $options, bool $merge = true)
 * @method static NotyfBuilder option(string $name, string $value)
 * @method static NotyfBuilder success(string $message = null, array $options = array())
 * @method static NotyfBuilder error(string $message = null, array $options = array())
 * @method static NotyfBuilder info(string $message = null, array $options = array())
 * @method static NotyfBuilder warning(string $message = null, array $options = array())
 * @method static NotyfBuilder priority(int $priority)
 * @method static NotyfBuilder hops(int $amount)
 * @method static NotyfBuilder keep()
 * @method static NotyfBuilder delay(int $delay)
 * @method static NotyfBuilder now()
 * @method static NotyfBuilder with(StampInterface[] $stamps = array())
 * @method static NotyfBuilder withStamp(StampInterface $stamp)
 * @method static NotyfBuilder handler(string $handler)
 * @method static Envelope     getEnvelope()
 * @method static NotyfBuilder duration(int $duration)
 * @method static NotyfBuilder ripple(bool $ripple)
 * @method static NotyfBuilder position(string $position, string $value)
 * @method static NotyfBuilder dismissible(bool $dismissible)
 */
class Notyf extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flasher.notyf';
    }
}
