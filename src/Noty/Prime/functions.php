<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;

if (!\function_exists('Flasher\Noty\Prime\noty')) {
    /**
     * @param array{
     *     layout?: "top"|"topLeft"|"topCenter"|"topRight"|"center"|"centerLeft"|"centerRight"|"bottom"|"bottomLeft"|"bottomCenter"|"bottomRight",
     *     theme?: "relax"|"mint"|"metroui",
     *     timeout?: false|int,
     *     progressBar?: bool,
     *     closeWith?: string[],
     *     animation?: array{
     *         open?: string|null,
     *         close?: string|null,
     *     },
     *     sounds?: array{
     *         sources?: string[],
     *         volume?: int,
     *         conditions?: string[],
     *     },
     *     docTitle?: array{
     *         conditions?: string[],
     *     },
     *     modal?: bool,
     *     id?: bool|string,
     *     force?: bool,
     *     queue?: string,
     *     killer?: bool|string,
     *     container?: false|string,
     *     buttons?: string[],
     *     visibilityControl?: bool,
     * } $options
     *
     * @phpstan-return ($message is empty ? NotyInterface : Envelope)
     */
    function noty(?string $message = null, string $type = Type::SUCCESS, array $options = [], ?string $title = null): Envelope|NotyInterface
    {
        $factory = FlasherContainer::create('flasher.noty');

        if (0 === \func_num_args()) {
            return $factory;
        }

        return $factory->flash($type, $message, $options, $title); // @phpstan-ignore-line
    }
}
