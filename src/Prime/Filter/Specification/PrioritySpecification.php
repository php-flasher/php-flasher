<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PriorityStamp;

final class PrioritySpecification implements SpecificationInterface
{
    /**
     * @param  int  $minPriority
     */
    public function __construct(private $minPriority, private readonly ?int $maxPriority = null)
    {
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PriorityStamp::class);

        if (! $stamp instanceof PriorityStamp) {
            return false;
        }

        if (null === $this->maxPriority) {
            return $stamp->getPriority() >= $this->minPriority;
        }

        if ($stamp->getPriority() <= $this->maxPriority) {
            return $stamp->getPriority() >= $this->minPriority;
        }

        return false;
    }
}
