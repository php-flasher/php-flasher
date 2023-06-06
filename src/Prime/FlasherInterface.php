<?php

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotificationBuilderInterface
 */
interface FlasherInterface
{
    /**
     * Get a notification factory instance.
     *
     * @throws \InvalidArgumentException
     */
    public function use(string $alias): NotificationFactoryInterface;

    /**
     * Register a custom notification factory.
     */
    public function addFactory(string $alias, callable|NotificationFactoryInterface $factory): void;

    /**
     * Renders the flash notifications based on the specified criteria, presenter, and context.
     *
     * @param array<string, mixed> $criteria  the criteria to filter the notifications
     * @param string|"html"|"json" $presenter The presenter format for rendering the notifications (e.g., 'html', 'json').
     * @param array<string, mixed> $context   additional context or options for rendering
     *
     * @phpstan-return ($presenter is 'html' ? string : mixed)
     */
    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed;
}
