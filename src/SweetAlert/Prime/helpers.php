<?php

declare(strict_types=1);

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;
use Flasher\SweetAlert\Prime\SweetAlertInterface;

if (!function_exists('sweetalert')) {
    /**
     * @phpstan-param string|null $message
     * @phpstan-param "success"|"info"|"warning"|"error"|"question" $type
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
     * } $options
     * @phpstan-param string|null $title
     *
     * @phpstan-return ($message is empty ? SweetAlertInterface : Envelope)
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
