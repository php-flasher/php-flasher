<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;

final class StampsCriteria implements CriteriaInterface
{
    public const STRATEGY_AND = 'and';
    public const STRATEGY_OR = 'or';

    /**
     * @var string[] $stamps
     */
    private readonly array $stamps;

    /**
     * @param  string|string[]  $stamps
     * @param  string  $strategy
     */
    public function __construct(string|array $stamps, private readonly string $strategy)
    {
        $this->stamps = (array) $stamps;
    }

    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn(Envelope $e) => $this->isSatisfiedBy($e));
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        $diff = array_diff($this->stamps, array_keys($envelope->all()));

        if (self::STRATEGY_AND === $this->strategy) {
            return [] === $diff;
        }

        return \count($diff) < \count($this->stamps);
    }
}
