<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Flasher\Pnotify\Prime\PnotifyFactory;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;

if (!function_exists('pnotify')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param array<string, mixed> $options
     *
     * @return Envelope|PnotifyFactory
     */
    function pnotify($message = null, $type = NotificationInterface::SUCCESS, array $options = array())
    {
        /** @var PnotifyFactory $factory */
        $factory = FlasherContainer::create('flasher.pnotify');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->addFlash($type, $message, $options);
    }
}
