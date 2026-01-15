<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!\function_exists('Flasher\Prime\flash')) {
    /**
     * @param array<string, mixed> $options
     *
     * @phpstan-return ($message is empty ? FlasherInterface : Envelope)
     */
    function flash(?string $message = null, string $type = Type::SUCCESS, array $options = [], ?string $title = null): Envelope|FlasherInterface
    {
        $factory = FlasherContainer::create('flasher');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
