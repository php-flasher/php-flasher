<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\OrderableStampInterface;
use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;

final class OrderByCriteria implements CriteriaInterface
{
    public const ASC = 'ASC';
    public const DESC = 'DESC';

    /**
     * @var array<string, class-string<StampInterface>>
     */
    private array $aliases = [
        'context' => ContextStamp::class,
        'created_at' => CreatedAtStamp::class,
        'delay' => DelayStamp::class,
        'handler' => PluginStamp::class,
        'hops' => HopsStamp::class,
        'preset' => PresetStamp::class,
        'priority' => PriorityStamp::class,
        'translation' => TranslationStamp::class,
        'unless' => UnlessStamp::class,
        'uuid' => IdStamp::class,
        'when' => WhenStamp::class,
    ];

    /**
     * @var array<class-string<StampInterface>, "ASC"|"DESC">
     */
    private array $orderings = [];

    public function __construct(mixed $criteria)
    {
        if (!\is_string($criteria) && !\is_array($criteria)) {
            throw new \InvalidArgumentException(sprintf('Invalid type for criteria "order_by". Expect a "string" or an "array", got "%s".', get_debug_type($criteria)));
        }

        foreach ((array) $criteria as $field => $direction) {
            if (\is_int($field)) {
                $field = $direction;
                $direction = self::ASC;
            }

            if (!\is_string($field)) {
                throw new \InvalidArgumentException(sprintf('Invalid Field value, must be "string", got "%s".', get_debug_type($field)));
            }

            if (!\is_string($direction)) {
                throw new \InvalidArgumentException(sprintf('Invalid Direction value, must be "string", got "%s".', get_debug_type($direction)));
            }

            $direction = strtoupper($direction);

            if (!\in_array($direction, [self::ASC, self::DESC], true)) {
                throw new \InvalidArgumentException(sprintf('Invalid ordering direction: must be "ASC" or "DESC", got "%s".', $direction));
            }

            $field = $this->aliases[$field] ?? $field;
            if (!is_a($field, StampInterface::class, true)) {
                throw new \InvalidArgumentException(sprintf('Field "%s" is not a valid class-string of "%s".', $field, StampInterface::class));
            }

            $this->orderings[$field] = $direction;
        }
    }

    public function apply(array $envelopes): array
    {
        usort($envelopes, function (Envelope $first, Envelope $second): int {
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
