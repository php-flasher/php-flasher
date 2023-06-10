<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;

if (! \function_exists('flash')) {
    /**
     * @param  array<string, mixed>  $options
     */
    function flash(
        string $message = null,
        string $type = NotificationInterface::SUCCESS,
        array $options = [],
        string $title = null,
    ): Envelope|NotificationFactoryInterface {
        $factory = FlasherContainer::getInstance()->create('flasher');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
