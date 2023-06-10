<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter;

use Flasher\Prime\Filter\Criteria\CallbackCriteria;
use Flasher\Prime\Filter\Criteria\DelayCriteria;
use Flasher\Prime\Filter\Criteria\HopsCriteria;
use Flasher\Prime\Filter\Criteria\LimitCriteria;
use Flasher\Prime\Filter\Criteria\OrderByCriteria;
use Flasher\Prime\Filter\Criteria\PriorityCriteria;
use Flasher\Prime\Filter\Criteria\StampsCriteria;
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
use Flasher\Prime\Filter\Criteria\CriteriaInterface;

final class CriteriaBuilder
{
    /**
     * @var array<string, class-string<StampInterface>>
     */
    public array $stamps = [
        'context' => ContextStamp::class,
        'created_at' => CreatedAtStamp::class,
        'delay' => DelayStamp::class,
        'handler' => HandlerStamp::class,
        'hops' => HopsStamp::class,
        'preset' => PresetStamp::class,
        'priority' => PriorityStamp::class,
        'translation' => TranslationStamp::class,
        'unless' => UnlessStamp::class,
        'uuid' => IdStamp::class,
        'when' => WhenStamp::class,
    ];

    /**
     * @var array<string, CriteriaInterface>
     */
    private array $criteria = [];

    /**
     * @param  array{
     *     priority?: int|array{min?: int, max?: int},
     *     hops?: int|array{min?: int, max?: int},
     *     life?: int|array{min?: int, max?: int},
     *     delay?: int|array{min?: int, max?: int},
     *     order_by?: string|array{string, 'ASC'|'DESC'},
     *     limit?: int,
     *     stamps?: class-string<StampInterface>|array<class-string<StampInterface>>,
     *     filter?: callable|callable[],
     * } $config
     */
    public function build(array $config): Filter
    {
        $filter = new Filter();

        foreach ($config as $name => $value) {
            $criteria = match ($name) {
                'priority' => $this->getPriority($value),
                'hops' => $this->getHops($value),
                'delay' => $this->getDelay($value),
                'life' => $this->getLife($value),
                'order_by' => $this->getOrderBy($value),
                'limit' => $this->getLimit($value),
                'stamps' => $this->getStamps($value),
                'filter' => $this->getCallback($value),
                default => null,
            };

            if ($criteria instanceof CriteriaInterface) {
                $filter->addCriteria($criteria);

                continue;
            }

            if (!isset($this->criteria[$name])) {
                throw new \InvalidArgumentException("Criteria '{$name}' is not registered.");
            }

            $filter->addCriteria($this->criteria[$name]);
        }

        return $filter;
    }

    /**
     * @param int|array{min?: int, max?: int} $criteria
     */
    public function getPriority(int|array $criteria): CriteriaInterface
    {
        $criteria = $this->extractMinMax($criteria);

        return new PriorityCriteria($criteria['min'], $criteria['max']);
    }

    /**
     * @param int|array{min?: int, max?: int} $criteria
     */
    public function getHops(int|array $criteria): CriteriaInterface
    {
        $criteria = $this->extractMinMax($criteria);

        return new HopsCriteria($criteria['min'], $criteria['max']);
    }

    /**
     * @param int|array{min?: int, max?: int} $criteria
     */
    public function getLife(int|array $criteria): CriteriaInterface
    {
        $criteria = $this->extractMinMax($criteria);

        return new HopsCriteria($criteria['min'], $criteria['max']);
    }

    /**
     * @param int|array{min?: int, max?: int} $criteria
     */
    public function getDelay(int|array $criteria): CriteriaInterface
    {
        $criteria = $this->extractMinMax($criteria);

        return new DelayCriteria($criteria['min'], $criteria['max']);
    }

    /**
     * @param string|array{string, "ASC"|"DESC"} $criteria
     *
     * @example array{
     *     "created_at": "ASC",
     *     "priority": "DESC",
     * }
     *
     * @example "priority"
     */
    public function getOrderBy(string|array $criteria): CriteriaInterface
    {
        $orderings = [];

        foreach ((array) $criteria as $field => $direction) {
            if (\is_int($field)) {
                $field = $direction;
                $direction = Filter::ASC;
            }

            if (\array_key_exists($field, $this->stamps)) {
                $field = $this->stamps[$field];
            }

            $orderings[$field] = strtoupper($direction);
        }

        return new OrderByCriteria($orderings);
    }

    public function getLimit(int $criteria): CriteriaInterface
    {
        return new LimitCriteria($criteria);
    }

    public function getStamps(array $criteria): CriteriaInterface
    {
        /** @var string $strategy */
        $strategy = $this->criteria['stamps_strategy'] ?? StampsCriteria::STRATEGY_OR;

        /** @var array<string, class-string<StampInterface>> $stamps */
        $stamps = (array) $this->criteria['stamps'];

        /**
         * @var string                       $key
         * @var class-string<StampInterface> $value
         */
        foreach ($stamps as $key => $value) {
            if (\array_key_exists($value, $this->stamps)) {
                $stamps[$key] = $this->stamps[$value];
            }
        }

        return new StampsCriteria($stamps, $strategy);
    }

    /**
     * @param callable[]|callable $criteria
     */
    public function getCallback(array|callable $criteria): CriteriaInterface
    {
        return new CallbackCriteria((array) $criteria);
    }

    /**
     * @param int|array{min?: int, max?: int} $criteria
     *
     * @return array{min: ?int, max: ?int}
     */
    private function extractMinMax(int|array $criteria): array
    {
        if (! \is_array($criteria)) {
            $criteria = ['min' => $criteria];
        }

        $min = $criteria['min'] ?? null;
        $max = $criteria['max'] ?? null;

        return ['min' => $min, 'max' => $max];
    }
}
