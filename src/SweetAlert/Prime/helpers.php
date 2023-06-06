<?php

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\SweetAlert\Prime\SweetAlertFactory;

if (!function_exists('sweetalert')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param array<string, mixed> $options
     *
     * @return Envelope|SweetAlertFactory
     */
    function sweetalert($message = null, $type = NotificationInterface::SUCCESS, array $options = [])
    {
        /** @var SweetAlertFactory $factory */
        $factory = FlasherContainer::create('flasher.sweetalert');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->addFlash($type, $message, $options);
    }
}
