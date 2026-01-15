<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class PriorityStamp implements OrderableStampInterface, PresentableStampInterface, StampInterface
{
    public function __construct(private int $priority)
    {
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function compare(StampInterface $orderable): int
    {
        if (!$orderable instanceof self) {
            return 1;
        }

        return $this->priority - $orderable->priority;
    }

    /**
     * @return array{priority: int}
     */
    public function toArray(): array
    {
        return ['priority' => $this->priority];
    }
}
