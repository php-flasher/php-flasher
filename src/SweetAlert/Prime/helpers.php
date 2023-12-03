<?php

declare(strict_types=1);

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;

if (!\function_exists('sweetalert')) {
    /**
     * @param array<string, mixed> $options
     */
    function sweetalert(
        string $message = null,
        string $type = NotificationInterface::SUCCESS,
        array $options = [],
        string $title = null,
    ): Envelope|SweetAlertFactory {
        $factory = FlasherContainer::getInstance()->create('flasher.sweetalert');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
