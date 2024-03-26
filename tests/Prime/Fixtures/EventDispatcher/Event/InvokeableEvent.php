<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Fixtures\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;

final class InvokeableEvent implements StoppableEventInterface
{
    private bool $invoked = false;
    private int $invokeCount = 0;
    private bool $propagationStopped = false;

    public function invoke(): void
    {
        $this->invoked = true;
        ++$this->invokeCount;
    }

    public function isInvoked(): bool
    {
        return $this->invoked;
    }

    public function getInvokeCount(): int
    {
        return $this->invokeCount;
    }

    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }
}
