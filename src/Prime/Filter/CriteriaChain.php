<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter;

use Flasher\Prime\Filter\Criteria\CriteriaInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;

final class CriteriaChain
{
    /**
     * @var CriteriaInterface[]
     */
    private array $criteriaChain = [];

    public function addCriteria(CriteriaInterface $criteria): void
    {
        $this->criteriaChain[] = $criteria;
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return Envelope[]
     */
    public function applyAll(array $envelopes): array
    {
        foreach ($this->criteriaChain as $criteria) {
            $envelopes = $criteria->apply($envelopes);
        }

        return $envelopes;
    }
}
