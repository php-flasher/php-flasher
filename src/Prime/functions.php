<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!\function_exists('Flasher\Prime\flash')) {
    /**
     * Creates a flash message or returns the Flasher factory.
     *
     * This function provides a convenient shorthand for working with PHPFlasher.
     * It serves as the primary entry point in namespaced contexts.
     *
     * Design pattern: Gateway - Provides a simple entry point to the complex API.
     *
     * @param string|null          $message The message content of the flash notification
     * @param string               $type    The notification type (success, error, warning, info)
     * @param array<string, mixed> $options Additional configuration options
     * @param string|null          $title   The notification title
     *
     * @return Envelope|FlasherInterface Returns an Envelope when creating a notification,
     *                                   or a FlasherInterface when called with no arguments
     *
     * @phpstan-return ($message is empty ? FlasherInterface : Envelope)
     *
     * Example usage:
     * ```php
     * // Get the flasher factory
     * $flasher = \Flasher\Prime\flash();
     * $flasher->info('Information message');
     *
     * // Create a notification directly
     * \Flasher\Prime\flash('Operation successful', Type::SUCCESS);
     *
     * // With additional options
     * \Flasher\Prime\flash('Profile updated', Type::SUCCESS, ['timeout' => 5000], 'Success');
     * ```
     */
    function flash(?string $message = null, string $type = Type::SUCCESS, array $options = [], ?string $title = null): Envelope|FlasherInterface
    {
        $factory = FlasherContainer::create('flasher');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
