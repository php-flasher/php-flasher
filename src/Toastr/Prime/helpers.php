<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Notification\Envelope;

if (! \function_exists('toastr')) {
    /**
     * @param  string  $message
     * @param  string  $type
     * @param  string  $title
     * @param  array<string, mixed>  $options
     * @return Envelope|ToastrFactory
     */
    function toastr($message = null, $type = \Flasher\Prime\Notification\NotificationInterface::SUCCESS, $title = '', array $options = [])
    {
        /** @var ToastrFactory $factory */
        $factory = \Flasher\Prime\Container\FlasherContainer::create('flasher.toastr');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->title($title)->addFlash($type, $message, $options);
    }
}
