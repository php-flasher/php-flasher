<?php

declare(strict_types=1);

use Flasher\Notyf\Prime\NotyfInterface;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!function_exists('notyf')) {
    /**
     * @param array{
     *     duration?: int,
     *     ripple?: bool,
     *     position?: array{
     *         x: "left"|"center"|"right",
     *         y: "top"|"center"|"bottom",
     *     },
     *     dismissible?: bool,
     *     background?: string,
     * } $options
     *
     * @phpstan-return ($message is empty ? NotyfInterface : Envelope)
     */
    function notyf(?string $message = null, string $type = Type::SUCCESS, array $options = [], ?string $title = null): Envelope|NotyfInterface
    {
        $factory = FlasherContainer::create('flasher.notyf');

        if (0 === func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
