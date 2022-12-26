<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Flasher\Noty\Prime\NotyFactory;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;

if (!function_exists('noty')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param array<string, mixed> $options
     *
     * @return Envelope|NotyFactory
     */
    function noty($message = null, $type = NotificationInterface::SUCCESS, array $options = array())
    {
        /** @var NotyFactory $factory */
        $factory = FlasherContainer::create('flasher.noty');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->addFlash($type, $message, $options);
    }
}
