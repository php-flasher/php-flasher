<?php

declare(strict_types=1);

use Flasher\Noty\Prime\NotyInterface;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!function_exists('noty')) {
    /**
     * Creates a Noty notification or returns the Noty factory.
     *
     * This function simplifies the process of creating Noty notifications.
     * When called with no arguments, it returns an instance of NotyInterface.
     * When called with arguments, it creates a Noty notification and returns an Envelope.
     *
     * @param string|null          $message the message content of the notification
     * @param string               $type    The type of the notification (e.g., success, error, warning, info).
     * @param array<string, mixed> $options additional options for the Noty notification
     * @param string|null          $title   the title of the notification
     *
     * @return Envelope|NotyInterface Returns an Envelope containing the notification details when arguments are provided.
     *                                Returns an instance of NotyInterface when no arguments are provided.
     *
     * @phpstan-return ($message is empty ? NotyInterface : Envelope)
     *
     * Usage:
     * 1. Without arguments - Get the Noty factory: $noty = noty();
     * 2. With arguments - Create and return a Noty notification:
     *    noty('Message', Type::SUCCESS, ['option' => 'value'], 'Title');
     */
    function noty(?string $message = null, string $type = Type::SUCCESS, array $options = [], ?string $title = null): Envelope|NotyInterface
    {
        $factory = FlasherContainer::create('flasher.noty');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
