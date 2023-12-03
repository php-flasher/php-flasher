<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Notification\Envelope;

if (!\function_exists('notyf')) {
    /**
     * @param string               $message
     * @param string               $type
     * @param array<string, mixed> $options
     *
     * @return Envelope|NotyfFactory
     */
    function notyf($message = null, $type = \Flasher\Prime\Notification\NotificationInterface::SUCCESS, array $options = [])
    {
        /** @var NotyfFactory $factory */
        $factory = \Flasher\Prime\Container\FlasherContainer::create('flasher.notyf');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->addFlash($type, $message, $options);
    }
}
