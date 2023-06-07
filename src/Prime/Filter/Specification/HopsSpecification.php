<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

final class HopsSpecification implements SpecificationInterface
{
    /**
     * @param  int  $minAmount
     */
    public function __construct(private $minAmount, private readonly ?int $maxAmount = null)
    {
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        $stamp = $envelope->get(\Flasher\Prime\Stamp\HopsStamp::class);

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
