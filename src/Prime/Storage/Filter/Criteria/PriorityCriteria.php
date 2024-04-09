<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PriorityStamp;

final readonly class PriorityCriteria implements CriteriaInterface
{
    use RangeExtractor;

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
        return array_filter($envelopes, fn (Envelope $envelope): bool => $this->match($envelope));
    }

    public function match(Envelope $envelope): bool
    {
        $stamp = $envelope->get(PriorityStamp::class);

        if (!$stamp instanceof PriorityStamp) {
            return false;
        }

        $priority = $stamp->getPriority();

        if (null === $this->maxPriority) {
            return $priority >= $this->minPriority;
        }

        if ($priority <= $this->maxPriority) {
            return $priority >= $this->minPriority;
        }

        return false;
    }
}
