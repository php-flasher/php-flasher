<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class HopsStamp implements StampInterface
{
    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(private int $amount)
    {
        if ($amount < 1) {
            throw new \InvalidArgumentException('Hops amount must be a positive integer (>= 1).');
        }
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
