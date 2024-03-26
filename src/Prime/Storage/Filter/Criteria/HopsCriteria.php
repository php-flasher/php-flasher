<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

final readonly class HopsCriteria implements CriteriaInterface
{
    use RangeExtractor;

    private readonly ?int $minAmount;

    private readonly ?int $maxAmount;

    public function __construct(mixed $criteria)
    {
        $criteria = $this->extractRange('priority', $criteria);

        $this->minAmount = $criteria['min'];
        $this->maxAmount = $criteria['max'];
    }

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

        if (null === $this->maxAmount) {
            return $stamp->getAmount() >= $this->minAmount;
        }

        if ($stamp->getAmount() <= $this->maxAmount) {
            return $stamp->getAmount() >= $this->minAmount;
        }

        return false;
    }
}
