<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * PriorityStamp - Controls notification priority for ordering.
 *
 * This stamp assigns a priority value to notifications, which affects their
 * display order. Higher priority notifications are typically displayed before
 * lower priority ones. This stamp also implements the OrderableStampInterface to
 * participate in sorting operations and PresentableStampInterface to be included
 * in the notification's metadata.
 *
 * Design patterns:
 * - Value Object: Immutable object representing a specific concept
 * - Comparable: Implements comparison logic for sorting
 */
final readonly class PriorityStamp implements OrderableStampInterface, PresentableStampInterface, StampInterface
{
    /**
     * Creates a new PriorityStamp instance.
     *
     * @param int $priority The priority value (higher values typically displayed first)
     */
    public function __construct(private int $priority)
    {
    }

    /**
     * Gets the priority value.
     *
     * @return int The priority value
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * Compares this stamp with another for ordering purposes.
     *
     * This method implements the comparison logic required by OrderableStampInterface.
     * It returns a positive value if this stamp has higher priority, negative if lower,
     * or zero if equal.
     *
     * @param StampInterface $orderable The stamp to compare with
     *
     * @return int Negative if this has lower priority, positive if higher, zero if equal
     */
    public function compare(StampInterface $orderable): int
    {
        if (!$orderable instanceof self) {
            return 1;
        }

        return $this->priority - $orderable->priority;
    }

    /**
     * Converts the stamp to an array representation.
     *
     * This method implements the serialization logic required by PresentableStampInterface.
     *
     * @return array{priority: int} The array representation
     */
    public function toArray(): array
    {
        return ['priority' => $this->priority];
    }
}
