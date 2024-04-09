<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Fixtures\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;

final class StoppableEvent implements StoppableEventInterface
{
    private bool $propagationStopped = false;

    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }
}
