<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class HopsStamp implements StampInterface
{
    public function __construct(private int $amount)
    {
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
