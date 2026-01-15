<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!\function_exists('Flasher\Toastr\Prime\toastr')) {
    /**
     * @param 'success'|'info'|'warning'|'error' $type
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
     * } $options
     *
     * @phpstan-return ($message is empty ? ToastrInterface : Envelope)
     */
    function toastr(?string $message = null, string $type = Type::SUCCESS, array $options = [], ?string $title = null): Envelope|ToastrInterface
    {
        $factory = FlasherContainer::create('flasher.toastr');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
