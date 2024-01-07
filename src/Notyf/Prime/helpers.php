<?php

declare(strict_types=1);

use Flasher\Notyf\Prime\NotyfInterface;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!function_exists('notyf')) {
    /**
     * Creates a Notyf notification or returns the Notyf factory.
     *
     * This function simplifies the process of creating Notyf notifications.
     * When called with no arguments, it returns an instance of NotyfInterface.
     * When called with arguments, it creates a Notyf notification and returns an Envelope.
     *
     * @param string|null          $message the message content of the notification
     * @param string               $type    The type of the notification (e.g., success, error, warning, info).
     * @param array<string, mixed> $options additional options for the Notyf notification
     * @param string|null          $title   the title of the notification
     *
     * @return Envelope|NotyfInterface Returns an Envelope containing the notification details when arguments are provided.
     *                                 Returns an instance of NotyfInterface when no arguments are provided.
     *
     * Usage:
     * 1. Without arguments - Get the Notyf factory: $notyf = notyf();
     * 2. With arguments - Create and return a Notyf notification:
     *    notyf('Message', Type::SUCCESS, ['option' => 'value'], 'Title');
     */
    function notyf(string $message = null, string $type = Type::SUCCESS, array $options = [], string $title = null): Envelope|NotyfInterface
    {
        $factory = FlasherContainer::create('flasher.notyf');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
