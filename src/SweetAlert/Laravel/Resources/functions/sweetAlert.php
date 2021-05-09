<?php

use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\App;

if (!function_exists('sweetAlert')) {
    /**
     * @param string $message
     * @param string $type
     *
     * @return \Flasher\SweetAlert\Prime\SweetAlertFactory
     */
    function sweetAlert($message = null, $type = NotificationInterface::TYPE_SUCCESS, array $options = array())
    {
        if (null === $message) {
            return App::make('flasher.sweet_alert');
        }

        return App::make('flasher.sweet_alert')->addFlash($type, $message, $options);
    }
}
