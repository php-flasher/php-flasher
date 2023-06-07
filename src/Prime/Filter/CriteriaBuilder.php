<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter;

use Flasher\Prime\Filter\Specification\CallbackSpecification;
use Flasher\Prime\Filter\Specification\DelaySpecification;
use Flasher\Prime\Filter\Specification\HopsSpecification;
use Flasher\Prime\Filter\Specification\PrioritySpecification;
use Flasher\Prime\Filter\Specification\StampsSpecification;
use Flasher\Prime\Stamp\StampInterface;

final class CriteriaBuilder
{
    /**
     * @var array<string, class-string<StampInterface>>
     */
    public $aliases = [
        'context' => \Flasher\Prime\Stamp\ContextStamp::class,
        'created_at' => \Flasher\Prime\Stamp\CreatedAtStamp::class,
        'delay' => \Flasher\Prime\Stamp\DelayStamp::class,
        'handler' => \Flasher\Prime\Stamp\HandlerStamp::class,
        'hops' => \Flasher\Prime\Stamp\HopsStamp::class,
        'preset' => \Flasher\Prime\Stamp\PresetStamp::class,
        'priority' => \Flasher\Prime\Stamp\PriorityStamp::class,
        'translation' => \Flasher\Prime\Stamp\TranslationStamp::class,
        'unless' => \Flasher\Prime\Stamp\UnlessStamp::class,
        'uuid' => \Flasher\Prime\Stamp\IdStamp::class,
        'view' => \Flasher\Prime\Stamp\ViewStamp::class,
        'when' => \Flasher\Prime\Stamp\WhenStamp::class,
    ];

    /**
     * @param  array<string, mixed>  $criteria
     */
    public function __construct(private readonly Filter $filter, private array $criteria)
    {
    }

    public function build(): void
    {
        $this->buildPriority();
        $this->buildHops();
        $this->buildDelay();
        $this->buildLife();
        $this->buildOrder();
        $this->buildLimit();
        $this->buildStamps();
        $this->buildCallback();
    }

    public function buildPriority(): void
    {
        if (! isset($this->criteria['priority'])) {
            return;
        }

        $criteria = $this->extractMinMax($this->criteria['priority']);

        $this->filter->addSpecification(new PrioritySpecification($criteria['min'], $criteria['max']));
    }

    public function buildHops(): void
    {
        if (! isset($this->criteria['hops'])) {
            return;
        }

        $criteria = $this->extractMinMax($this->criteria['hops']);

        $this->filter->addSpecification(new HopsSpecification($criteria['min'], $criteria['max']));
    }

    public function buildDelay(): void
    {
        if (! isset($this->criteria['delay'])) {
            return;
        }

        $criteria = $this->extractMinMax($this->criteria['delay']);

        $this->filter->addSpecification(new DelaySpecification($criteria['min'], $criteria['max']));
    }

    public function buildLife(): void
    {
        if (! isset($this->criteria['life'])) {
            return;
        }

        $criteria = $this->extractMinMax($this->criteria['life']);

        $this->filter->addSpecification(new HopsSpecification($criteria['min'], $criteria['max']));
    }

    public function buildOrder(): void
    {
        if (! isset($this->criteria['order_by'])) {
            return;
        }

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

        $this->filter->orderBy($orderings);
    }

    public function buildLimit(): void
    {
        if (! isset($this->criteria['limit'])) {
            return;
        }

        /** @var int $limit */
        $limit = $this->criteria['limit'];
        $this->filter->setMaxResults((int) $limit);
    }

    public function buildStamps(): void
    {
        if (! isset($this->criteria['stamps'])) {
            return;
        }

        /** @var string $strategy */
        $strategy = $this->criteria['stamps_strategy'] ?? StampsSpecification::STRATEGY_OR;

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

        $this->filter->addSpecification(new StampsSpecification($stamps, $strategy));
    }

    public function buildCallback(): void
    {
        if (! isset($this->criteria['filter'])) {
            return;
        }

        /** @var callable $callback */
        foreach ((array) $this->criteria['filter'] as $callback) {
            $this->filter->addSpecification(new CallbackSpecification($this->filter, $callback));
        }
    }

    /**
     * @return array{min: int, max: int}
     */
    private function extractMinMax($criteria): array
    {
        if (! \is_array($criteria)) {
            $criteria = ['min' => $criteria];
        }

        $min = $criteria['min'] ?? null;
        $max = $criteria['max'] ?? null;

        return ['min' => $min, 'max' => $max];
    }
}
