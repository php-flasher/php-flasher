<?php

declare(strict_types=1);

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!function_exists('flash')) {
    /**
     * Creates a flash message or returns the Flasher factory.
     *
     * This global function provides a convenient way to access PHPFlasher from anywhere
     * in your application without namespace qualification. It serves dual purposes:
     *
     * 1. When called with no arguments: Returns the flasher factory for method chaining
     * 2. When called with arguments: Creates and stores a flash notification
     *
     * Design pattern: Gateway - Provides a simple, global entry point to the complex API.
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
     * $flasher = flash();
     * $flasher->info('Information message');
     *
     * // Create a notification directly
     * flash('Operation successful', Type::SUCCESS);
     *
     * // With additional options
     * flash('Profile updated', Type::SUCCESS, ['timeout' => 5000], 'Success');
     * ```
     */
    function flash(?string $message = null, string $type = Type::SUCCESS, array $options = [], ?string $title = null): Envelope|FlasherInterface
    {
        $factory = FlasherContainer::create('flasher');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
