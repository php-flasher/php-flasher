<?php

use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\App;

if (!function_exists('noty')) {
    /**
     * @param string $message
     * @param string $type
     *
     * @return \Flasher\Noty\Prime\NotyFactory
     */
    function noty($message = null, $type = NotificationInterface::TYPE_SUCCESS, array $options = array())
    {
        if (null === $message) {
            return App::make('flasher.noty');
        }

        return App::make('flasher.noty')->addFlash($type, $message, $options);
    }
}
