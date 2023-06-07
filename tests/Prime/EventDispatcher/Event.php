<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher;

final class Event implements \Flasher\Prime\EventDispatcher\Event\StoppableEventInterface
{
    private bool $propagationStopped = false;

    public function __construct(private $data = null)
    {
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}
