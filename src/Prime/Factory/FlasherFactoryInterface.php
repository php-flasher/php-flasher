<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

/**
 * Factory interface for creating Flasher-specific notification builders.
 *
 * This interface extends the base NotificationFactoryInterface to provide
 * type safety when working specifically with the default Flasher implementation.
 * It ensures that methods like createNotificationBuilder() return Flasher-specific
 * builder instances.
 *
 * @mixin \Flasher\Prime\Notification\FlasherBuilder
 */
interface FlasherFactoryInterface extends NotificationFactoryInterface
{
}
