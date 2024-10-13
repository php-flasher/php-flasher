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
     * @param string|null                                              $message the message content of the notification
     * @param "success"|"info"|"warning"|"error"|"alert"|"information" $type    The type of the notification (e.g., success, error, warning, info).
     * @param array{
     *     layout?: "top"|"topLeft"|"topCenter"|"topRight"|"center"|"centerLeft"|"centerRight"|"bottom"|"bottomLeft"|"bottomCenter"|"bottomRight",
     *     theme?: "relax"|"mint"|"metroui",
     *     timeout?: false|int,
     *     progressBar?: bool,
     *     closeWith?: string[],
     *     animation?: array{
     *         open?: string|null,
     *         close?: string|null,
     *     },
     *     sounds?: array{
     *         sources?: string[],
     *         volume?: int,
     *         conditions?: string[],
     *     },
     *     docTitle?: array{
     *         conditions?: string[],
     *     },
     *     modal?: bool,
     *     id?: bool|string,
     *     force?: bool,
     *     queue?: string,
     *     killer?: bool|string,
     *     container?: false|string,
     *     buttons?: string[],
     *     visibilityControl?: bool,
     * } $options additional options for the Noty notification
     * @param string|null $title the title of the notification
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
