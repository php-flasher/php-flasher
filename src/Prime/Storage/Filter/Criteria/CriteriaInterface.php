<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;

/**
 * Contract for notification filtering criteria.
 */
interface CriteriaInterface
{
    /**
     * @param Envelope[] $envelopes
     *
     * @return Envelope[]
     */
    public function apply(array $envelopes): array;
}
