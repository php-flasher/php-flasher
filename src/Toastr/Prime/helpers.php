<?php

declare(strict_types=1);

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;
use Flasher\Toastr\Prime\ToastrInterface;

if (!function_exists('toastr')) {
    /**
     * Creates a Toastr notification or returns the Toastr factory.
     *
     * This function simplifies the process of creating Toastr notifications.
     * When called with no arguments, it returns an instance of ToastrInterface.
     * When called with arguments, it creates a Toastr notification and returns an Envelope.
     *
     * @param string|null          $message the message content of the notification
     * @param string               $type    The type of the notification (e.g., success, error, warning, info).
     * @param array<string, mixed> $options additional options for the Toastr notification
     * @param string|null          $title   the title of the notification
     *
     * @return Envelope|ToastrInterface Returns an Envelope containing the notification details when arguments are provided.
     *                                  Returns an instance of ToastrInterface when no arguments are provided.
     *
     * @phpstan-return ($message is empty ? ToastrInterface : Envelope)
     *
     * Usage:
     * 1. Without arguments - Get the Toastr factory: $toastr = toastr();
     * 2. With arguments - Create and return a Toastr notification:
     *    toastr('Message', Type::SUCCESS, ['option' => 'value'], 'Title');
     */
    function toastr(?string $message = null, string $type = Type::SUCCESS, array $options = [], ?string $title = null): Envelope|ToastrInterface
    {
        $factory = FlasherContainer::create('flasher.toastr');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
