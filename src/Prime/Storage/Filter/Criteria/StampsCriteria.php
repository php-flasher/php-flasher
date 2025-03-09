<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;

/**
 * StampsCriteria - Filters notifications by the presence of specific stamps.
 *
 * This criterion filters envelopes based on whether they have specific stamps.
 * It supports two filtering strategies:
 * - AND: Envelope must have all specified stamps
 * - OR: Envelope must have at least one of the specified stamps
 *
 * Design pattern: Specification - Defines filter logic based on stamp presence.
 */
final class StampsCriteria implements CriteriaInterface
{
    /**
     * Strategy constant for requiring all stamps (logical AND).
     */
    public const STRATEGY_AND = 'and';

    /**
     * Strategy constant for requiring at least one stamp (logical OR).
     */
    public const STRATEGY_OR = 'or';

    /**
     * The stamps to check for.
     *
     * @var array<string, mixed>
     */
    private array $stamps = [];

    /**
     * Creates a new StampsCriteria instance.
     *
     * @param mixed  $criteria An array of stamp class names to check for
     * @param string $strategy The matching strategy to use (AND or OR)
     *
     * @throws \InvalidArgumentException If the criteria is not an array
     */
    public function __construct(mixed $criteria, private readonly string $strategy = self::STRATEGY_AND)
    {
        if (!\is_array($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'stamps'.");
        }

        foreach ($criteria as $key => $value) {
            $this->stamps[$key] = $value;
        }
    }

    /**
     * Filters envelopes based on stamp presence.
     *
     * @param Envelope[] $envelopes The notification envelopes to filter
     *
     * @return Envelope[] Envelopes that match the stamp criteria
     */
    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $e): bool => $this->match($e));
    }

    /**
     * Checks if an envelope matches the stamps criteria.
     *
     * @param Envelope $envelope The envelope to check
     *
     * @return bool True if the envelope matches the criteria, false otherwise
     */
    public function match(Envelope $envelope): bool
    {
        $diff = array_diff($this->stamps, array_keys($envelope->all()));

        if (self::STRATEGY_AND === $this->strategy) {
            return [] === $diff;
        }

        return \count($diff) < \count($this->stamps);
    }
}
