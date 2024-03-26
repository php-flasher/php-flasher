<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class DelayStamp implements StampInterface
{
    public function __construct(private int $delay)
    {
    }

    public function getDelay(): int
    {
        return $this->delay;
    }
}
