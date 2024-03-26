<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PresenterStamp;

final class PresenterCriteria implements CriteriaInterface
{
    private string $presenter;

    public function __construct(mixed $criteria)
    {
        if (!\is_string($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'presenter'.");
        }

        $this->presenter = $criteria;
    }

    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, function (Envelope $envelope) {
            $pattern = $envelope->get(PresenterStamp::class)?->getPattern() ?: '/.*/';

            return 1 === preg_match($pattern, $this->presenter);
        });
    }
}
