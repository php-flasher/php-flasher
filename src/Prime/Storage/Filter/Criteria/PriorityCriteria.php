<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PriorityStamp;

final class PriorityCriteria implements CriteriaInterface
{
    use ExtractRange;

    private ?int $minPriority;

    private ?int $maxPriority;

    public function __construct(mixed $criteria)
    {
        $criteria = $this->extractRange('priority', $criteria);

        $this->minPriority = $criteria['min'];
        $this->maxPriority = $criteria['max'];
    }

    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $e) => $this->match($e));
    }

    public function match(Envelope $envelope): bool
    {
        $stamp = $envelope->get(PriorityStamp::class);

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
