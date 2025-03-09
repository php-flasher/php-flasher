<?php

declare(strict_types=1);

namespace Flasher\Notyf\Laravel\Facade;

use Flasher\Notyf\Prime\NotyfBuilder;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\StampInterface;
use Illuminate\Support\Facades\Facade;

/**
 * Notyf - Laravel facade for Notyf notifications.
 *
 * This facade provides a static interface to Notyf's functionality within Laravel,
 * following Laravel's facade pattern. It offers comprehensive IDE autocompletion
 * for all Notyf builder methods.
 *
 * Design patterns:
 * - Facade: Provides a simplified, static interface to a complex subsystem
 * - Proxy: Acts as a proxy to the underlying Notyf service
 *
 * Usage examples:
 * ```php
 * // Simple notification
 * Notyf::success('Operation completed successfully');
 *
 * // Chained configuration
 * Notyf::duration(3000)
 *      ->dismissible(true)
 *      ->position('x', 'right')
 *      ->position('y', 'top')
 *      ->success('Record saved');
 * ```
 *
 * @method static NotyfBuilder success(string $message, array<string, mixed> $options = array())
 * @method static NotyfBuilder error(string $message, array<string, mixed> $options = array())
 * @method static NotyfBuilder warning(string $message, array<string, mixed> $options = array())
 * @method static NotyfBuilder info(string $message, array<string, mixed> $options = array())
 * @method static NotyfBuilder flash(StampInterface[] $stamps = array())
 * @method static NotyfBuilder message(string $message)
 * @method static NotyfBuilder options(array<string, mixed> $options, bool $merge = true)
 * @method static NotyfBuilder option(string $name, string $value)
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
final class Notyf extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string The service container binding key for Notyf
     */
    protected static function getFacadeAccessor(): string
    {
        return 'flasher.notyf';
    }
}
