<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;

final class StampsCriteria implements CriteriaInterface
{
    public const STRATEGY_AND = 'and';
    public const STRATEGY_OR = 'or';

    /**
     * @var array<string, mixed>
     */
    private array $stamps = [];

    public function __construct(mixed $criteria, private readonly string $strategy = self::STRATEGY_AND)
    {
        if (!\is_array($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'stamps'.");
        }

        foreach ($criteria as $key => $value) {
            $this->stamps[$key] = $value;
        }
    }

    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $e): bool => $this->match($e));
    }

    public function match(Envelope $envelope): bool
    {
        $diff = array_diff($this->stamps, array_keys($envelope->all()));

        if (self::STRATEGY_AND === $this->strategy) {
            return [] === $diff;
        }

        return \count($diff) < \count($this->stamps);
    }
}
