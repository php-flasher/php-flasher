<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

final class HopsCriteria implements CriteriaInterface
{
    public function __construct(
        private readonly int $minAmount,
        private readonly ?int $maxAmount = null,
    ) {
    }

    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn(Envelope $e) => $this->isSatisfiedBy($e));
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        $stamp = $envelope->get(HopsStamp::class);

        if (! $stamp instanceof HopsStamp) {
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
