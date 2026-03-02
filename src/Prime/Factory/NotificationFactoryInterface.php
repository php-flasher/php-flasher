<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Stamp\StampInterface;

/**
 * Interface for notification factories that create notification builders.
 *
 * @mixin \Flasher\Prime\Notification\NotificationBuilderInterface
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
interface NotificationFactoryInterface
{
    /**
     * Create a new notification builder instance.
     */
    public function createNotificationBuilder(): NotificationBuilderInterface;
}
