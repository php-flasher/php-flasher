<?php

use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\App;

if (!function_exists('toastr')) {
    /**
     * @param string $message
     * @param string $type
     * @param string $title
     *
     * @return \Flasher\Toastr\Prime\ToastrFactory
     */
    function toastr($message = null, $type = NotificationInterface::TYPE_SUCCESS, $title = '', array $options = array())
    {
        if (null === $message) {
            return App::make('flasher.toastr');
        }

        return App::make('flasher.toastr')
            ->title($title)
            ->addFlash($type, $message, $options);
    }
}
