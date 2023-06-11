<?php

declare(strict_types=1);

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Toastr\Prime\ToastrFactory;

if (! \function_exists('toastr')) {
    /**
     * @param  array<string, mixed>  $options
     */
    function toastr(
        string $message = null,
        string $type = NotificationInterface::SUCCESS,
        array $options = [],
        string $title = null,
    ): Envelope|ToastrFactory {
        $factory = FlasherContainer::getInstance()->create('flasher.toastr_factory');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
