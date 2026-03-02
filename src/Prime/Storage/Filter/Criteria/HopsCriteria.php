<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

final readonly class HopsCriteria implements CriteriaInterface
{
    use RangeExtractor;

    private ?int $minAmount;

    private ?int $maxAmount;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(mixed $criteria)
    {
        $criteria = $this->extractRange('hops', $criteria);

        $this->minAmount = $criteria['min'];
        $this->maxAmount = $criteria['max'];
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return Envelope[]
     */
    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $e): bool => $this->match($e));
    }

    public function match(Envelope $envelope): bool
    {
        $stamp = $envelope->get(HopsStamp::class);

        if (!$stamp instanceof HopsStamp) {
            return false;
        }

        $amount = $stamp->getAmount();

        $meetsMin = null === $this->minAmount || $amount >= $this->minAmount;
        $meetsMax = null === $this->maxAmount || $amount <= $this->maxAmount;

        return $meetsMin && $meetsMax;
    }
}
