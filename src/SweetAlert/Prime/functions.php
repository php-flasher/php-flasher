<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!\function_exists('Flasher\SweetAlert\Prime\sweetalert')) {
    /**
     * Creates a Sweetalert notification or returns the Sweetalert factory.
     *
     * This function simplifies the process of creating Sweetalert notifications.
     * When called with no arguments, it returns an instance of SweetAlertInterface.
     * When called with arguments, it creates a Sweetalert notification and returns an Envelope.
     *
     * @param string|null          $message the message content of the notification
     * @param string               $type    The type of the notification (e.g., success, error, warning, info).
     * @param array<string, mixed> $options additional options for the Sweetalert notification
     * @param string|null          $title   the title of the notification
     *
     * @return Envelope|SweetAlertInterface Returns an Envelope containing the notification details when arguments are provided.
     *                                      Returns an instance of SweetAlertInterface when no arguments are provided.
     *
     * @phpstan-return ($message is empty ? SweetAlertInterface : Envelope)
     *
     * Usage:
     * 1. Without arguments - Get the Sweetalert factory: $sweetalert = sweetalert();
     * 2. With arguments - Create and return a Sweetalert notification:
     *    sweetalert('Message', Type::SUCCESS, ['option' => 'value'], 'Title');
     */
    function sweetalert(?string $message = null, string $type = Type::SUCCESS, array $options = [], ?string $title = null): Envelope|SweetAlertInterface
    {
        $factory = FlasherContainer::create('flasher.sweetalert');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
