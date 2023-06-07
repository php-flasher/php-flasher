<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

if (! \function_exists('sweetalert')) {
    /**
     * @param  array<string, mixed>  $options
     */
    function sweetalert(
        string $message = null,
        string $type = \Flasher\Prime\Notification\NotificationInterface::SUCCESS,
        array $options = [],
        string $title = null,
    ): \Flasher\Prime\Notification\Envelope|SweetAlertFactory {
        $factory = \Flasher\Prime\Container\FlasherContainer::getInstance()->create('flasher.sweetalert');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
