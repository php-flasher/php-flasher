<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter;

use Flasher\Prime\Filter\Criteria\DelayCriteria;
use Flasher\Prime\Filter\Criteria\HopsCriteria;
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
    public array $aliases = [
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
     * @var array<string, class-string<CriteriaInterface>>
     */
    protected static $customCriteria = [];

    /**
     * @param  array{
     *     priority?: int|array{min?: int, max?: int},
     *     hops?: int|array{min?: int, max?: int},
     *     delay?: int|array{min?: int, max?: int},
     *     life?: int|array{min?: int, max?: int},
     * } $criteria
     */
    public function __construct(
        private readonly CriteriaChain $criteriaChain,
        private readonly array $criteria,
    ) {
    }

    public function build(array $config): CriteriaChain
    {
        $chain = new CriteriaChain();

        foreach ($config as $name => $value) {
            if (!isset($this->criteria[$name])) {
                throw new \InvalidArgumentException("Criteria '{$name}' is not registered.");
            }

            $criteria = match ($name) {
                'priority' => $this->buildPriority($value),
                'hops' => $this->buildHops($value),
                'delay' => $this->buildDelay($value),
                'life' => $this->buildLife($value),
                'order_by' => $this->buildOrder($value),
                'limit' => $this->buildLimit($value),
                'stamps' => $this->buildStamps($value),
                'filter' => $this->buildCallback($value),
                default => $this->getCustomCriteria($name, $value)
            };

            $chain->addCriteria($criteria);
        }

        return $chain;
    }

    public function registerCriteria(string $name, CriteriaInterface $criteria): void
    {
        $this->customCriteria[$name] = $criteria;
    }

    private function getCustomCriteria(string $criteriaName, $value): ?CriteriaInterface
    {
        if (isset($this->customCriteria[$criteriaName])) {
            return $this->customCriteria[$criteriaName]->withValue($value);
        }

        return null;
    }

    public function buildPriority(array $criteria): CriteriaInterface
    {
        $criteria = $this->extractMinMax($criteria['priority']);

        return new PriorityCriteria($criteria['min'], $criteria['max']);
    }

    public function buildHops(): CriteriaInterface
    {
        $criteria = $this->extractMinMax($this->criteria['hops']);

        return new HopsCriteria($criteria['min'], $criteria['max']);
    }

    public function buildDelay(): CriteriaInterface
    {
        $criteria = $this->extractMinMax($this->criteria['delay']);

        return new DelayCriteria($criteria['min'], $criteria['max']);
    }

    public function buildLife(): CriteriaInterface
    {
        $criteria = $this->extractMinMax($this->criteria['life']);

        return new HopsCriteria($criteria['min'], $criteria['max']);
    }

    public function buildOrder(): CriteriaInterface
    {
        $orderings = [];

        /**
         * @var int|string $field
         * @var string     $direction
         */
        foreach ((array) $this->criteria['order_by'] as $field => $direction) {
            if (\is_int($field)) {
                $field = $direction;
                $direction = Filter::ASC;
            }

            $direction = Filter::ASC === strtoupper($direction) ? Filter::ASC : Filter::DESC;

            if (\array_key_exists($field, $this->aliases)) {
                $field = $this->aliases[$field];
            }

            $orderings[$field] = $direction;
        }

        $this->criteriaChain->orderBy($orderings);
    }

    public function buildLimit(): CriteriaInterface
    {
        if (! isset($this->criteria['limit'])) {
            return;
        }

        /** @var int $limit */
        $limit = $this->criteria['limit'];
        $this->criteriaChain->setMaxResults((int) $limit);
    }

    public function buildStamps(): CriteriaInterface
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
            if (\array_key_exists($value, $this->aliases)) {
                $stamps[$key] = $this->aliases[$value];
            }
        }

        return new StampsCriteria($stamps, $strategy);
    }

    public function buildCallback(): CriteriaInterface
    {
        if (! isset($this->criteria['filter'])) {
            return;
        }

        /** @var callable $callback */
        foreach ((array) $this->criteria['filter'] as $callback) {
            $this->criteriaChain->addCriteria(new CallbackCriteria($this->criteriaChain, $callback));
        }
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
