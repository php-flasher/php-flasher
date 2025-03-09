<?php

declare(strict_types=1);

namespace Flasher\Toastr\Laravel\Facade;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Toastr\Prime\ToastrBuilder;
use Illuminate\Support\Facades\Facade;

/**
 * Toastr - Laravel facade for Toastr notifications.
 *
 * This facade provides a static interface to Toastr's functionality within Laravel,
 * following Laravel's facade pattern. It offers comprehensive IDE autocompletion
 * for all Toastr builder methods through PHPDoc annotations.
 *
 * Design patterns:
 * - Facade: Provides a simplified, static interface to a complex subsystem
 * - Proxy: Acts as a proxy to the underlying Toastr service
 * - Static Gateway: Provides static access to instance methods
 *
 * Usage examples:
 * ```php
 * // Simple notification
 * Toastr::success('Operation completed successfully');
 *
 * // Chained configuration
 * Toastr::positionClass('toast-bottom-right')
 *     ->progressBar(true)
 *     ->timeOut(5000)
 *     ->success('Your changes have been saved');
 * ```
 *
 * @method static ToastrBuilder flash(StampInterface[] $stamps = array())
 * @method static ToastrBuilder type(string $type, string $message = null, array<string, mixed> $options = array())
 * @method static ToastrBuilder message(string $message)
 * @method static ToastrBuilder options(array<string, mixed> $options, bool $merge = true)
 * @method static ToastrBuilder option(string $name, $value)
 * @method static ToastrBuilder success(string $message = null, array<string, mixed> $options = array())
 * @method static ToastrBuilder error(string $message = null, array<string, mixed> $options = array())
 * @method static ToastrBuilder info(string $message = null, array<string, mixed> $options = array())
 * @method static ToastrBuilder warning(string $message = null, array<string, mixed> $options = array())
 * @method static ToastrBuilder priority(int $priority)
 * @method static ToastrBuilder hops(int $amount)
 * @method static ToastrBuilder keep()
 * @method static ToastrBuilder delay(int $delay)
 * @method static ToastrBuilder now()
 * @method static ToastrBuilder with(StampInterface[] $stamps = array())
 * @method static ToastrBuilder withStamp(StampInterface $stamp)
 * @method static ToastrBuilder handler(string $handler)
 * @method static Envelope      getEnvelope()
 * @method static ToastrBuilder title(string $title)
 * @method static ToastrBuilder closeButton(bool $closeButton = true)
 * @method static ToastrBuilder closeClass(string $closeClass)
 * @method static ToastrBuilder closeDuration(int $closeDuration)
 * @method static ToastrBuilder closeEasing(string $closeEasing)
 * @method static ToastrBuilder closeHtml(string $closeHtml)
 * @method static ToastrBuilder closeMethod(string $closeMethod)
 * @method static ToastrBuilder closeOnHover(bool $closeOnHover = true)
 * @method static ToastrBuilder containerId(string $containerId)
 * @method static ToastrBuilder debug(bool $debug = true)
 * @method static ToastrBuilder escapeHtml(bool $escapeHtml = true)
 * @method static ToastrBuilder extendedTimeOut(int $extendedTimeOut)
 * @method static ToastrBuilder hideDuration(int $hideDuration)
 * @method static ToastrBuilder hideEasing(string $hideEasing)
 * @method static ToastrBuilder hideMethod(string $hideMethod)
 * @method static ToastrBuilder iconClass(string $iconClass)
 * @method static ToastrBuilder messageClass(string $messageClass)
 * @method static ToastrBuilder newestOnTop(bool $newestOnTop = true)
 * @method static ToastrBuilder onHidden(string $onHidden)
 * @method static ToastrBuilder onShown(string $onShown)
 * @method static ToastrBuilder positionClass(string $positionClass)
 * @method static ToastrBuilder preventDuplicates(bool $preventDuplicates = true)
 * @method static ToastrBuilder progressBar(bool $progressBar = true)
 * @method static ToastrBuilder progressClass(string $progressClass)
 * @method static ToastrBuilder rtl(bool $rtl = true)
 * @method static ToastrBuilder showDuration(int $showDuration)
 * @method static ToastrBuilder showEasing(string $showEasing)
 * @method static ToastrBuilder showMethod(string $showMethod)
 * @method static ToastrBuilder tapToDismiss(bool $tapToDismiss = true)
 * @method static ToastrBuilder target(string $target)
 * @method static ToastrBuilder timeOut(int $timeOut, bool $extendedTimeOut = null)
 * @method static ToastrBuilder titleClass(string $titleClass)
 * @method static ToastrBuilder toastClass(string $toastClass)
 * @method static ToastrBuilder persistent()
 */
final class Toastr extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * Returns the service container binding key for the Toastr service.
     *
     * @return string The service container binding key
     */
    protected static function getFacadeAccessor(): string
    {
        return 'flasher.toastr';
    }
}
