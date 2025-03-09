<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * OrderableStampInterface - Contract for stamps that affect notification ordering.
 *
 * This interface identifies stamps that provide ordering behavior for notifications.
 * It defines a comparison method that can be used to sort notifications based on
 * stamp-specific criteria.
 *
 * Design patterns:
 * - Comparable: Defines an interface for objects that can be compared for ordering
 * - Strategy: Allows different ordering strategies to be implemented and used interchangeably
 */
interface OrderableStampInterface
{
    /**
     * Compares this stamp with another for determining ordering.
     *
     * This method should return:
     * - A negative value if this stamp should be ordered before the other
     * - A positive value if this stamp should be ordered after the other
     * - Zero if the stamps are equivalent for ordering purposes
     *
     * @param StampInterface $orderable The stamp to compare with
     *
     * @return int Negative if before, positive if after, zero if equivalent
     */
    public function compare(StampInterface $orderable): int;
}
