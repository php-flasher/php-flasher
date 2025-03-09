<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\FlasherBuilder;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * Default implementation of FlasherFactoryInterface.
 *
 * This factory creates FlasherBuilder instances for constructing notifications
 * with the default PHPFlasher implementation. It extends the base NotificationFactory
 * to inherit common factory functionality.
 *
 * Design pattern: Factory Method - Defines an interface for creating objects,
 * but lets subclasses decide which class to instantiate.
 *
 * @mixin \Flasher\Prime\Notification\FlasherBuilder
 */
final class FlasherFactory extends NotificationFactory implements FlasherFactoryInterface
{
    /**
     * Creates a new FlasherBuilder instance.
     *
     * This implementation returns a FlasherBuilder configured with the current plugin name.
     * The builder provides a fluent API for constructing notifications with type-safe methods.
     *
     * @return NotificationBuilderInterface The created notification builder
     */
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new FlasherBuilder($this->plugin ?? 'flasher', $this->storageManager);
    }
}
