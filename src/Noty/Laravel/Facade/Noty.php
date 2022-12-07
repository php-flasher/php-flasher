<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Noty\Laravel\Facade;

use Flasher\Noty\Prime\NotyBuilder;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Prime\Stamp\StampInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static NotyBuilder addSuccess(string $message, array $options = array())
 * @method static NotyBuilder addError(string $message, array $options = array())
 * @method static NotyBuilder addWarning(string $message, array $options = array())
 * @method static NotyBuilder addInfo(string $message, array $options = array())
 * @method static NotyBuilder addFlash(NotificationInterface|string $type, string $message = null, array $options = array())
 * @method static NotyBuilder flash(StampInterface[] $stamps = array())
 * @method static NotyBuilder type(string $type, string $message = null, array $options = array())
 * @method static NotyBuilder message(string $message)
 * @method static NotyBuilder options(array $options, bool $merge = true)
 * @method static NotyBuilder option(string $name, string $value)
 * @method static NotyBuilder success(string $message = null, array $options = array())
 * @method static NotyBuilder error(string $message = null, array $options = array())
 * @method static NotyBuilder info(string $message = null, array $options = array())
 * @method static NotyBuilder warning(string $message = null, array $options = array())
 * @method static NotyBuilder priority(int $priority)
 * @method static NotyBuilder hops(int $amount)
 * @method static NotyBuilder keep()
 * @method static NotyBuilder delay(int $delay)
 * @method static NotyBuilder now()
 * @method static NotyBuilder with(StampInterface[] $stamps = array())
 * @method static NotyBuilder withStamp(StampInterface $stamp)
 * @method static NotyBuilder handler(string $handler)
 * @method static Envelope    getEnvelope()
 * @method static NotyBuilder text(string $text)
 * @method static NotyBuilder alert(string $message = null, array $options = array())
 * @method static NotyBuilder layout(string $layout)
 * @method static NotyBuilder theme(string $theme)
 * @method static NotyBuilder timeout(bool|int $timeout)
 * @method static NotyBuilder progressBar(bool $progressBar = false)
 * @method static NotyBuilder closeWith(array|string $closeWith)
 * @method static NotyBuilder animation(string $animation, string $effect)
 * @method static NotyBuilder sounds(string $option, mixed $value)
 * @method static NotyBuilder docTitle(string $option, mixed $docTitle)
 * @method static NotyBuilder modal(bool $modal = true)
 * @method static NotyBuilder id(bool|string $id)
 * @method static NotyBuilder force(bool $force = true)
 * @method static NotyBuilder queue(string $queue)
 * @method static NotyBuilder killer(bool|string $killer)
 * @method static NotyBuilder container(bool|string $container)
 * @method static NotyBuilder buttons(array $buttons)
 * @method static NotyBuilder visibilityControl(bool $visibilityControl)
 */
class Noty extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flasher.noty';
    }
}
