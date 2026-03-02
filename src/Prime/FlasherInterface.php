<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Response\Presenter\ArrayPresenter;
use Flasher\Prime\Stamp\StampInterface;

/**
 * Main entry point for creating flash notifications.
 *
 * @mixin \Flasher\Prime\Notification\NotificationBuilder
 *
 * @phpstan-import-type ArrayPresenterType from ArrayPresenter
 *
 * @method $this    title(string $title)                                                                                            Set the notification title
 * @method $this    message(string $message)                                                                                        Set the notification message
 * @method $this    type(string $type) Set the notification type (success, error, info, warning)
 * @method $this    options(array<string, mixed> $options, bool $append = true)                                                     Set notification options
 * @method $this    option(string $name, mixed $value)                                                                              Set a single notification option
 * @method $this    priority(int $priority)                                                                                         Set the notification priority
 * @method $this    hops(int $amount)                                                                                               Set the number of requests the notification should persist
 * @method $this    keep()                                                                                                          Keep the notification for one more request
 * @method $this    delay(int $delay)                                                                                               Set the delay in milliseconds before showing the notification
 * @method $this    translate(array<string, mixed> $parameters = [], ?string $locale = null)                                        Mark the notification for translation
 * @method $this    handler(string $handler)                                                                                        Set the notification handler/adapter
 * @method $this    context(array<string, mixed> $context)                                                                          Set additional context data
 * @method $this    when(bool|\Closure $condition)                                                                                  Conditionally show the notification
 * @method $this    unless(bool|\Closure $condition)                                                                                Conditionally hide the notification
 * @method $this    with(StampInterface[]|StampInterface $stamps)                                                                   Add stamps to the notification
 * @method Envelope getEnvelope()                                                                                                   Get the notification envelope
 * @method Envelope success(string $message, array<string, mixed> $options = [], ?string $title = null)                             Create a success notification
 * @method Envelope error(string $message, array<string, mixed> $options = [], ?string $title = null)                               Create an error notification
 * @method Envelope info(string $message, array<string, mixed> $options = [], ?string $title = null)                                Create an info notification
 * @method Envelope warning(string $message, array<string, mixed> $options = [], ?string $title = null)                             Create a warning notification
 * @method Envelope flash(?string $type = null, ?string $message = null, array<string, mixed> $options = [], ?string $title = null) Create a flash notification
 * @method Envelope push()                                                                                                          Push the notification to storage
 * @method Envelope created(string|object|null $resource = null)                                                                    Create a "resource created" notification
 * @method Envelope updated(string|object|null $resource = null)                                                                    Create a "resource updated" notification
 * @method Envelope saved(string|object|null $resource = null)                                                                      Create a "resource saved" notification
 * @method Envelope deleted(string|object|null $resource = null)                                                                    Create a "resource deleted" notification
 */
interface FlasherInterface
{
    /**
     * @phpstan-return ($alias is 'flasher' ? \Flasher\Prime\Factory\FlasherFactoryInterface :
     *          ($alias is 'noty' ? \Flasher\Noty\Prime\NotyInterface :
     *          ($alias is 'notyf' ? \Flasher\Notyf\Prime\NotyfInterface :
     *          ($alias is 'sweetalert' ? \Flasher\SweetAlert\Prime\SweetAlertInterface :
     *          ($alias is 'toastr' ? \Flasher\Toastr\Prime\ToastrInterface :
     *                  \Flasher\Prime\Factory\NotificationFactoryInterface)))))
     */
    public function use(string $alias): NotificationFactoryInterface;

    /**
     * @phpstan-return ($alias is 'flasher' ? \Flasher\Prime\Factory\FlasherFactoryInterface :
     *          ($alias is 'noty' ? \Flasher\Noty\Prime\NotyInterface :
     *          ($alias is 'notyf' ? \Flasher\Notyf\Prime\NotyfInterface :
     *          ($alias is 'sweetalert' ? \Flasher\SweetAlert\Prime\SweetAlertInterface :
     *          ($alias is 'toastr' ? \Flasher\Toastr\Prime\ToastrInterface :
     *                  \Flasher\Prime\Factory\NotificationFactoryInterface)))))
     */
    public function create(string $alias): NotificationFactoryInterface;

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, mixed> $context
     *
     * @phpstan-return ($presenter is 'html' ? string :
     *          ($presenter is 'array' ? ArrayPresenterType :
     *          ($presenter is 'json' ? ArrayPresenterType :
     *                      mixed)))
     */
    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed;
}
