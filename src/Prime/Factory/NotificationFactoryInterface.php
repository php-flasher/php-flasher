<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * NotificationFactoryInterface - Core factory abstraction.
 *
 * Defines the contract for all notification factories that can create
 * notification builders. This interface enables the system to work
 * with different notification implementations through a common API.
 *
 * Design pattern: Abstract Factory - Provides an interface for creating
 * families of related objects without specifying concrete classes.
 *
 * @mixin \Flasher\Prime\Notification\NotificationBuilderInterface
 */
interface NotificationFactoryInterface
{
    /**
     * Creates a notification builder instance.
     *
     * Each implementation of this method should return a builder tailored
     * to the specific notification library or system that the factory supports.
     *
     * @return NotificationBuilderInterface A builder for constructing notifications
     */
    public function createNotificationBuilder(): NotificationBuilderInterface;
}
