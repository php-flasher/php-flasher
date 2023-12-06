<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\OrderableStampInterface;
use Flasher\Prime\Stamp\StampInterface;

final class OrderByCriteria implements CriteriaInterface
{
    public const ASC = 'ASC';

    public const DESC = 'DESC';

    /**
     * @var array<string, "ASC"|"DESC">
     */
    private array $orderings = [];

    public function __construct(mixed $criteria)
    {
        if (!is_string($criteria) && !is_array($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'order_by'.");
        }

        foreach ((array) $criteria as $field => $direction) {
            if (\is_int($field)) {
                $field = $direction;
                $direction = self::ASC;
            }

            $direction = strtoupper((string) $direction);

            if (!in_array($direction, [self::ASC, self::DESC])) {
                throw new \InvalidArgumentException();
            }

            if (\array_key_exists($field, StampsCriteria::STAMP_ALIASES)) {
                $field = StampsCriteria::STAMP_ALIASES[$field];
            }

            $this->orderings[$field] = $direction;
        }
    }

    public function apply(array $envelopes): array
    {
        usort($envelopes, static function (Envelope $first, Envelope $second): int {
            /**
             * @var class-string<StampInterface> $field
             * @var string                       $ordering
             */
            foreach ($this->orderings as $field => $ordering) {
                $stampA = $first->get($field);
                $stampB = $second->get($field);

                if (!$stampA instanceof OrderableStampInterface || !$stampB instanceof OrderableStampInterface) {
                    return 0;
                }

                return self::ASC === $ordering
                    ? $stampA->compare($stampB)
                    : $stampB->compare($stampA);
            }

            return 0;
        });

        return $envelopes;
    }
}
