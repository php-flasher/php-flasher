<?php

declare(strict_types=1);

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!function_exists('flash')) {
    /**
     * Creates a flash message or returns the Flasher factory.
     *
     * This function serves a dual purpose:
     * 1. When called with no arguments, it returns an instance of FlasherInterface or NotificationFactoryInterface.
     *    This allows for accessing various methods provided by the Flasher factory.
     * 2. When called with arguments, it creates a flash message and returns an Envelope.
     *    This envelope contains the flash message details and can be used for further operations.
     *
     * @param string|null          $message the message content of the flash message
     * @param string               $type    The type of the message (e.g., success, error, warning, info).
     * @param array<string, mixed> $options additional options for the flash message
     * @param string|null          $title   the title of the flash message
     *
     * @return Envelope|FlasherInterface Returns an Envelope containing the message details when arguments are provided.
     *                                   Returns an instance of FlasherInterface or NotificationFactoryInterface when no arguments are provided.
     *
     * @phpstan-return ($message is empty ? FlasherInterface : Envelope)
     *
     * Usage:
     * 1. Without arguments - Get the Flasher factory: $flasher = flash();
     * 2. With arguments - Create and return a flash message:
     *    flash('Message', Type::SUCCESS, ['option' => 'value'], 'Title');
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
