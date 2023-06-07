<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final class DelayStamp implements StampInterface
{
    public function __construct(private readonly int $delay)
    {
    }

    public function getDelay(): int
    {
        return $this->delay;
    }
}
