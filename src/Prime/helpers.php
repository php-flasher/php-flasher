<?php

declare(strict_types=1);

namespace Flasher\Prime;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\StampInterface;

if (! \function_exists('flash')) {
    /**
     * @param  array<string, mixed>  $options
     * @param  StampInterface[]  $stamps
     */
    function flash(string $message = null, string $type = 'success', array $options = [], array $stamps = []): Envelope|FlasherInterface
    {
        /** @var FlasherInterface $factory */
        $factory = \Flasher\Prime\Container\FlasherContainer::create('flasher');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->with($stamps)->addFlash($type, $message, $options);
    }
}
