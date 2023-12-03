<?php

declare(strict_types=1);

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Notification\Envelope;

if (!\function_exists('pnotify')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param array<string, mixed> $options
     *
     * @return Envelope|PnotifyFactory
     */
    function pnotify($message = null, $type = \Flasher\Prime\Notification\NotificationInterface::SUCCESS, array $options = [])
    {
        /** @var PnotifyFactory $factory */
        $factory = \Flasher\Prime\Container\FlasherContainer::create('flasher.pnotify');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->addFlash($type, $message, $options);
    }
}
