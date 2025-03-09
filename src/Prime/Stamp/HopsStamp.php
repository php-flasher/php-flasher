<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * HopsStamp - Controls notification persistence across requests.
 *
 * This stamp defines how many request cycles ("hops") a notification should persist for.
 * A value of 1 means the notification will only appear in the current request,
 * while higher values allow notifications to survive across redirects or page loads.
 *
 * Design patterns:
 * - Value Object: Immutable object representing a specific concept
 * - Lifecycle Control: Controls the lifecycle of a notification across requests
 */
final readonly class HopsStamp implements StampInterface
{
    /**
     * Creates a new HopsStamp instance.
     *
     * @param int $amount The number of request cycles the notification should persist for
     */
    public function __construct(private int $amount)
    {
    }

    /**
     * Gets the amount of hops.
     *
     * @return int The number of request cycles
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}
