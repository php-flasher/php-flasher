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
     * @param string|null                        $message the message content of the notification
     * @param "success"|"info"|"warning"|"error" $type    The type of the notification (e.g., success, error, warning, info).
     * @param array{
     *     closeButton?: bool,
     *     closeClass?: string,
     *     closeDuration?: int,
     *     closeEasing?: string,
     *     closeHtml?: string,
     *     closeMethod?: string,
     *     closeOnHover?: bool,
     *     containerId?: string,
     *     debug?: bool,
     *     escapeHtml?: bool,
     *     extendedTimeOut?: int,
     *     hideDuration?: int,
     *     hideEasing?: string,
     *     hideMethod?: string,
     *     iconClass?: string,
     *     messageClass?: string,
     *     newestOnTop?: bool,
     *     onHidden?: string,
     *     onShown?: string,
     *     positionClass?: "toast-top-right"|"toast-top-center"|"toast-bottom-center"|"toast-top-full-width"|"toast-bottom-full-width"|"toast-top-left"|"toast-bottom-right"|"toast-bottom-left",
     *     preventDuplicates?: bool,
     *     progressBar?: bool,
     *     progressClass?: string,
     *     rtl?: bool,
     *     showDuration?: int,
     *     showEasing?: string,
     *     showMethod?: string,
     *     tapToDismiss?: bool,
     *     target?: string,
     *     timeOut?: int,
     *     titleClass?: string,
     *     toastClass?: string,
     * } $options additional options for the Toastr notification
     * @param string|null $title the title of the notification
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
