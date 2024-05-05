<?php

declare(strict_types=1);

namespace Flasher\Laravel\Facade;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Stamp\StampInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static NotificationBuilder title(string $message)
 * @method static NotificationBuilder message(string $message)
 * @method static NotificationBuilder type(string $message)
 * @method static NotificationBuilder options(array $options, bool $merge = true)
 * @method static NotificationBuilder option(string $name, $value)
 * @method static NotificationBuilder priority(int $priority)
 * @method static NotificationBuilder hops(int $amount)
 * @method static NotificationBuilder keep()
 * @method static NotificationBuilder delay(int $delay)
 * @method static NotificationBuilder translate(array $parameters = [], ?string $locale = null)
 * @method static NotificationBuilder handler(string $handler)
 * @method static NotificationBuilder context(array $context)
 * @method static NotificationBuilder when(bool|\Closure $condition)
 * @method static NotificationBuilder unless(bool|\Closure $condition)
 * @method static NotificationBuilder with(StampInterface[] $stamps = array())
 * @method static NotificationBuilder withStamp(StampInterface $stamp)
 * @method static Envelope            success(string $message, array $options = [], ?string $title = null)
 * @method static Envelope            error(string $message, array $options = [], ?string $title = null)
 * @method static Envelope            info(string $message, array $options = [], ?string $title = null)
 * @method static Envelope            warning(string $message, array $options = [], ?string $title = null)
 * @method static Envelope            flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null)
 * @method static Envelope            preset(string $preset, array $parameters = [])
 * @method static Envelope            operation(string $operation, string|object|null $resource = null)
 * @method static Envelope            created(string|object|null $resource = null)
 * @method static Envelope            updated(string|object|null $resource = null)
 * @method static Envelope            saved(string|object|null $resource = null)
 * @method static Envelope            deleted(string|object|null $resource = null)
 * @method static Envelope            push()
 * @method static Envelope            addSuccess(string $message, array $options = [], ?string $title = null)
 * @method static Envelope            addError(string $message, array $options = [], ?string $title = null)
 * @method static Envelope            addInfo(string $message, array $options = [], ?string $title = null)
 * @method static Envelope            addWarning(string $message, array $options = [], ?string $title = null)
 * @method static Envelope            addFlash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null)
 * @method static Envelope            addPreset(string $preset, array $parameters = [])
 * @method static Envelope            addCreated(string|object|null $resource = null)
 * @method static Envelope            addUpdated(string|object|null $resource = null)
 * @method static Envelope            addDeleted(string|object|null $resource = null)
 * @method static Envelope            addSaved(string|object|null $resource = null)
 * @method static Envelope            addOperation(string $operation, string|object|null $resource = null)
 * @method static Envelope            getEnvelope()
 */
final class Flasher extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'flasher';
    }
}
