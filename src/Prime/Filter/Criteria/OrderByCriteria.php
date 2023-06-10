<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\OrderableStampInterface;
use Flasher\Prime\Stamp\StampInterface;

class OrderByCriteria implements CriteriaInterface
{
    public function __construct(private readonly array $ordering)
    {
    }

    public function apply(array $envelopes): array
    {
        return $orderings = $this->orderings;
        usort($this->envelopes, static function (Envelope $first, Envelope $second) use ($orderings): int {
            /**
             * @var class-string<StampInterface> $field
             * @var string                       $ordering
             */
            foreach ($orderings as $field => $ordering) {
                $stampA = $first->get($field);
                $stampB = $second->get($field);

                if (! $stampA instanceof OrderableStampInterface || ! $stampB instanceof OrderableStampInterface) {
                    return 0;
                }

                if (self::ASC === $ordering) {
                    return $stampA->compare($stampB);
                }

                return $stampB->compare($stampA);
            }

            return 0;
        });
    }
}
