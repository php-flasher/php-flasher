<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class WhenStamp implements StampInterface
{
    public function __construct(private bool $condition)
    {
    }

    public function getCondition(): bool
    {
        return $this->condition;
    }
}
