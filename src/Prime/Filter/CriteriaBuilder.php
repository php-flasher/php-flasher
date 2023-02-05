<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
    public $aliases = array(
        'context' => 'Flasher\Prime\Stamp\ContextStamp',
        'created_at' => 'Flasher\Prime\Stamp\CreatedAtStamp',
        'delay' => 'Flasher\Prime\Stamp\DelayStamp',
        'handler' => 'Flasher\Prime\Stamp\HandlerStamp',
        'hops' => 'Flasher\Prime\Stamp\HopsStamp',
        'preset' => 'Flasher\Prime\Stamp\PresetStamp',
        'priority' => 'Flasher\Prime\Stamp\PriorityStamp',
        'translation' => 'Flasher\Prime\Stamp\TranslationStamp',
        'unless' => 'Flasher\Prime\Stamp\UnlessStamp',
        'uuid' => 'Flasher\Prime\Stamp\UuidStamp',
        'view' => 'Flasher\Prime\Stamp\ViewStamp',
        'when' => 'Flasher\Prime\Stamp\WhenStamp',
    );

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var array<string, mixed>
     */
    private $criteria;

    /**
     * @param array<string, mixed> $criteria
     */
    public function __construct(Filter $filter, array $criteria)
    {
        $this->filter = $filter;
        $this->criteria = $criteria;
    }

    /**
     * @return void
     */
    public function build()
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

    /**
     * @return void
     */
    public function buildPriority()
    {
        if (!isset($this->criteria['priority'])) {
            return;
        }

        $criteria = $this->extractMinMax($this->criteria['priority']);

        $this->filter->addSpecification(new PrioritySpecification($criteria['min'], $criteria['max']));
    }

    /**
     * @return void
     */
    public function buildHops()
    {
        if (!isset($this->criteria['hops'])) {
            return;
        }

        $criteria = $this->extractMinMax($this->criteria['hops']);

        $this->filter->addSpecification(new HopsSpecification($criteria['min'], $criteria['max']));
    }

    /**
     * @return void
     */
    public function buildDelay()
    {
        if (!isset($this->criteria['delay'])) {
            return;
        }

        $criteria = $this->extractMinMax($this->criteria['delay']);

        $this->filter->addSpecification(new DelaySpecification($criteria['min'], $criteria['max']));
    }

    /**
     * @return void
     */
    public function buildLife()
    {
        if (!isset($this->criteria['life'])) {
            return;
        }

        $criteria = $this->extractMinMax($this->criteria['life']);

        $this->filter->addSpecification(new HopsSpecification($criteria['min'], $criteria['max']));
    }

    /**
     * @return void
     */
    public function buildOrder()
    {
        if (!isset($this->criteria['order_by'])) {
            return;
        }

        $orderings = array();

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

    /**
     * @return void
     */
    public function buildLimit()
    {
        if (!isset($this->criteria['limit'])) {
            return;
        }

        /** @var int $limit */
        $limit = $this->criteria['limit'];
        $this->filter->setMaxResults((int) $limit);
    }

    /**
     * @return void
     */
    public function buildStamps()
    {
        if (!isset($this->criteria['stamps'])) {
            return;
        }

        /** @var string $strategy */
        $strategy = isset($this->criteria['stamps_strategy']) ? $this->criteria['stamps_strategy'] : StampsSpecification::STRATEGY_OR;

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

    /**
     * @return void
     */
    public function buildCallback()
    {
        if (!isset($this->criteria['filter'])) {
            return;
        }

        /** @var callable $callback */
        foreach ((array) $this->criteria['filter'] as $callback) {
            $this->filter->addSpecification(new CallbackSpecification($this->filter, $callback));
        }
    }

    /**
     * @param mixed $criteria
     *
     * @return array{min: int, max: int}
     */
    private function extractMinMax($criteria)
    {
        if (!\is_array($criteria)) {
            $criteria = array('min' => $criteria);
        }

        $min = isset($criteria['min']) ? $criteria['min'] : null;
        $max = isset($criteria['max']) ? $criteria['max'] : null;

        return array('min' => $min, 'max' => $max);
    }
}
