<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Flasher\Notyf\Prime\NotyfFactory;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;

if (!function_exists('notyf')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param array<string, mixed> $options
     *
     * @return Envelope|NotyfFactory
     */
    function notyf($message = null, $type = NotificationInterface::SUCCESS, array $options = array())
    {
        /** @var NotyfFactory $factory */
        $factory = FlasherContainer::create('flasher.notyf');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->addFlash($type, $message, $options);
    }
}
