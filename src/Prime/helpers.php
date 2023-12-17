<?php

declare(strict_types=1);

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!\function_exists('flash')) {
    /**
     * Creates a flash message or returns the Flasher factory.
     *
     * When called with no arguments, it returns an instance of FlasherInterface or NotificationFactoryInterface.
     * When called with arguments, it creates a flash message and returns an Envelope.
     *
     * @param string|null          $message The message content
     * @param string               $type    The type of the message (e.g., success, error)
     * @param array<string, mixed> $options Additional options for the flash message
     * @param string|null          $title   The title of the flash message
     */
    function flash(string $message = null, string $type = Type::SUCCESS, array $options = [], string $title = null): Envelope|FlasherInterface|NotificationFactoryInterface
    {
        $factory = FlasherContainer::create('flasher');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title);
    }
}
