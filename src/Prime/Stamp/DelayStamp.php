<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class DelayStamp implements StampInterface
{
    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(private int $delay)
    {
        if ($delay < 0) {
            throw new \InvalidArgumentException('Delay must be a non-negative integer (>= 0).');
        }
    }

    public function getDelay(): int
    {
        return $this->delay;
    }
}
