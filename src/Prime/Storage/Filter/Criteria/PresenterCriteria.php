<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PresenterStamp;

/**
 * PresenterCriteria - Filters notifications by presenter compatibility.
 *
 * This criterion filters envelopes based on whether they are compatible
 * with a specific presenter format. It uses regular expression patterns
 * from PresenterStamp to determine compatibility.
 *
 * Design pattern: Specification - Defines filter logic based on presenter compatibility.
 */
final class PresenterCriteria implements CriteriaInterface
{
    /**
     * The presenter format to check for compatibility.
     */
    private string $presenter;

    /**
     * Creates a new PresenterCriteria instance.
     *
     * @param mixed $criteria The presenter format name (e.g., 'html', 'json')
     *
     * @throws \InvalidArgumentException If the criteria is not a string
     */
    public function __construct(mixed $criteria)
    {
        if (!\is_string($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'presenter'.");
        }

        $this->presenter = $criteria;
    }

    /**
     * Filters envelopes by presenter compatibility.
     *
     * An envelope is compatible if it either has no presenter restrictions
     * or has a presenter pattern that matches the specified presenter format.
     *
     * @param Envelope[] $envelopes The notification envelopes to filter
     *
     * @return Envelope[] Envelopes that are compatible with the presenter
     */
    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, function (Envelope $envelope) {
            $pattern = $envelope->get(PresenterStamp::class)?->getPattern() ?: '/.*/';

            return 1 === preg_match($pattern, $this->presenter);
        });
    }
}
