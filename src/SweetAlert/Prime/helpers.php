<?php

declare(strict_types=1);

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;
use Flasher\SweetAlert\Prime\SweetAlertInterface;

if (!function_exists('sweetalert')) {
    /**
     * Creates a Sweetalert notification or returns the Sweetalert factory.
     *
     * This function simplifies the process of creating Sweetalert notifications.
     * When called with no arguments, it returns an instance of SweetAlertInterface.
     * When called with arguments, it creates a Sweetalert notification and returns an Envelope.
     *
     * @phpstan-param string|null $message the message content of the notification
     * @phpstan-param "success"|"info"|"warning"|"error"|"question" $type    The type of the notification (e.g., success, error, warning, info).
     * @phpstan-param array{
     *     title?: string,
     *     titleText?: string,
     *     html?: string,
     *     text?: string,
     *     icon?: string,
     *     iconColor?: string,
     *     iconHtml?: string,
     *     showClass?: mixed,
     *     hideClass?: mixed,
     *     footer?: string,
     *     backdrop?: bool|string,
     *     toast?: bool,
     *     target?: string,
     *     input?: "text"|"email"|"password"|"number"|"tel"|"range"|"textarea"|"search"|"url"|"select"|"radio"|"checkbox"|"file"|"date"|"datetime-local"|"time"|"week"|"month",
     *     width?: string,
     *     padding?: string,
     *     background?: string,
     *     position?: "top"|"top-start"|"top-end"|"center"|"center-start"|"center-end"|"bottom"|"bottom-start"|"bottom-end",
     *     grow?: "column"|"fullscreen"|"row"|false,
     *     customClass?: array<"container"|"popup"|"header"|"title"|"closeButton"|"icon"|"image"|"content"|"input"|"inputLabel"|"validationMessage"|"actions"|"confirmButton"|"denyButton"|"cancelButton"|"loader"|"footer", string>,
     *     timer?: int,
     *     timerProgressBar?: bool,
     *     heightAuto?: bool,
     *     allowOutsideClick?: bool|string,
     *     allowEscapeKey?: bool|string,
     *     allowEnterKey?: bool|string,
     *     stopKeydownPropagation?: bool,
     *     keydownListenerCapture?: bool,
     *     showConfirmButton?: bool,
     *     showDenyButton?: bool,
     *     showCancelButton?: bool,
     *     confirmButtonText?: string,
     *     denyButtonText?: string,
     *     cancelButtonText?: string,
     *     confirmButtonColor?: string,
     *     denyButtonColor?: string,
     *     cancelButtonColor?: string,
     *     confirmButtonAriaLabel?: string,
     *     denyButtonAriaLabel?: string,
     *     cancelButtonAriaLabel?: string,
     *     buttonsStyling?: bool,
     *     reverseButtons?: bool,
     *     focusConfirm?: bool,
     *     focusDeny?: bool,
     *     focusCancel?: bool,
     *     showCloseButton?: bool,
     *     closeButtonHtml?: string,
     *     closeButtonAriaLabel?: string,
     *     loaderHtml?: string,
     *     showLoaderOnConfirm?: bool,
     *     scrollbarPadding?: bool,
     *     preConfirm?: bool|string,
     *     preDeny?: string,
     *     returnInputValueOnDeny?: bool,
     *     animation?: bool,
     *     imageUrl?: string,
     *     imageWidth?: int,
     *     imageHeight?: int,
     *     imageAlt?: string,
     *     inputLabel?: string,
     *     inputPlaceholder?: string,
     *     inputValue?: string,
     *     inputOptions?: string,
     *     inputAutoTrim?: bool,
     *     inputAttributes?: string,
     *     inputValidator?: string,
     *     validationMessage?: string,
     * } $options additional options for the Sweetalert notification
     * @phpstan-param string|null $title the title of the notification
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

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
