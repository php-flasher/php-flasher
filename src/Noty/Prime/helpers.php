<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Notification\Envelope;

if (! \function_exists('noty')) {
    /**
     * @param  string  $message
     * @param  string  $type
     * @param  array<string, mixed>  $options
     * @return Envelope|NotyFactory
     */
    function noty($message = null, $type = \Flasher\Prime\Notification\NotificationInterface::SUCCESS, array $options = [])
    {
        /** @var NotyFactory $factory */
        $factory = \Flasher\Prime\Container\FlasherContainer::create('flasher.noty');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->addFlash($type, $message, $options);
    }
}
