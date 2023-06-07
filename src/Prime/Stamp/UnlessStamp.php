<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final class UnlessStamp implements StampInterface
{
    public function __construct(private readonly bool $condition)
    {
    }

    public function getCondition(): bool
    {
        return $this->condition;
    }
}
