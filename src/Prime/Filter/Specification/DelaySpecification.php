<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\DelayStamp;

final class DelaySpecification implements SpecificationInterface
{
    /**
     * @param  int  $minDelay
     */
    public function __construct(private $minDelay, private readonly ?int $maxDelay = null)
    {
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        $stamp = $envelope->get(\Flasher\Prime\Stamp\DelayStamp::class);

        if (! $stamp instanceof DelayStamp) {
            return false;
        }

        if (null === $this->maxDelay) {
            return $stamp->getDelay() >= $this->minDelay;
        }

        if ($stamp->getDelay() <= $this->maxDelay) {
            return $stamp->getDelay() >= $this->minDelay;
        }

        return false;
    }
}
