<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Pnotify\Laravel\Facade;

use Flasher\Pnotify\Prime\PnotifyBuilder;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Prime\Stamp\StampInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static PnotifyBuilder addSuccess(string $message, array $options = array())
 * @method static PnotifyBuilder addError(string $message, array $options = array())
 * @method static PnotifyBuilder addWarning(string $message, array $options = array())
 * @method static PnotifyBuilder addInfo(string $message, array $options = array())
 * @method static PnotifyBuilder addFlash(NotificationInterface|string $type, string $message = null, array $options = array())
 * @method static PnotifyBuilder flash(StampInterface[] $stamps = array())
 * @method static PnotifyBuilder type(string $type, string $message = null, array $options = array())
 * @method static PnotifyBuilder message(string $message)
 * @method static PnotifyBuilder options(array $options, bool $merge = true)
 * @method static PnotifyBuilder option(string $name, string $value)
 * @method static PnotifyBuilder success(string $message = null, array $options = array())
 * @method static PnotifyBuilder error(string $message = null, array $options = array())
 * @method static PnotifyBuilder info(string $message = null, array $options = array())
 * @method static PnotifyBuilder warning(string $message = null, array $options = array())
 * @method static PnotifyBuilder priority(int $priority)
 * @method static PnotifyBuilder hops(int $amount)
 * @method static PnotifyBuilder keep()
 * @method static PnotifyBuilder delay(int $delay)
 * @method static PnotifyBuilder now()
 * @method static PnotifyBuilder with(StampInterface[] $stamps = array())
 * @method static PnotifyBuilder withStamp(StampInterface $stamp)
 * @method static PnotifyBuilder handler(string $handler)
 * @method static Envelope       getEnvelope()
 * @method static PnotifyBuilder title(bool|string $title)
 * @method static PnotifyBuilder titleEscape(bool $titleEscape = true)
 * @method static PnotifyBuilder text(string $text)
 * @method static PnotifyBuilder textEscape(bool $textEscape = true)
 * @method static PnotifyBuilder styling(string $styling)
 * @method static PnotifyBuilder addClass(string $addClass)
 * @method static PnotifyBuilder cornerClass(string $cornerClass)
 * @method static PnotifyBuilder autoDisplay(bool $autoDisplay = true)
 * @method static PnotifyBuilder width(int $width)
 * @method static PnotifyBuilder minHeight(int $minHeight)
 * @method static PnotifyBuilder icon(bool $icon = true)
 * @method static PnotifyBuilder animation(string $animation)
 * @method static PnotifyBuilder animateSpeed(string $animateSpeed)
 * @method static PnotifyBuilder shadow(bool $shadow = true)
 * @method static PnotifyBuilder hide(bool $hide = true)
 * @method static PnotifyBuilder timer(int $timer)
 * @method static PnotifyBuilder mouseReset(bool $mouseReset = true)
 * @method static PnotifyBuilder remove(bool $remove = true)
 * @method static PnotifyBuilder insertBrs(bool $insertBrs = true)
 * @method static PnotifyBuilder destroy(bool $destroy = true)
 * @method static PnotifyBuilder desktop(string $desktop, mixed $value)
 * @method static PnotifyBuilder buttons(string $buttons, mixed $value)
 * @method static PnotifyBuilder nonblock(string $nonblock, mixed $value)
 * @method static PnotifyBuilder mobile(string $mobile, mixed $value)
 * @method static PnotifyBuilder animate(string $animate, mixed $value)
 * @method static PnotifyBuilder confirm(string $confirm, mixed $value)
 * @method static PnotifyBuilder history(string $history, mixed $value)
 */
class Pnotify extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flasher.pnotify';
    }
}
