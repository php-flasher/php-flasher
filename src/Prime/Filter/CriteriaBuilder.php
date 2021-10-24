<?php

namespace Flasher\Prime\Filter;

use Flasher\Prime\Filter\Specification\CallbackSpecification;
use Flasher\Prime\Filter\Specification\DelaySpecification;
use Flasher\Prime\Filter\Specification\HopsSpecification;
use Flasher\Prime\Filter\Specification\PrioritySpecification;
use Flasher\Prime\Filter\Specification\StampsSpecification;

final class CriteriaBuilder
{
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var array<string, mixed>
     */
    private $criteria;

    /**
     * @param array<string, mixed> $criteria
     */
    public function __construct(FilterBuilder $filterBuilder, array $criteria)
    {
        $this->filterBuilder = $filterBuilder;
        $this->criteria = $criteria;
    }

    /**
     * @return FilterBuilder
     */
    public function build()
    {
        $this->buildPriority();
        $this->buildHops();
        $this->buildDelay();
        $this->buildLife();
        $this->buildLimit();
        $this->buildOrder();
        $this->buildStamps();
        $this->buildFilter();

        return $this->filterBuilder;
    }

    /**
     * @return void
     */
    public function buildPriority()
    {
        if (!isset($this->criteria['priority'])) {
            return;
        }

        $priority = $this->criteria['priority'];

        if (!is_array($priority)) {
            $priority = array(
                'min' => $priority,
            );
        }

        $min = isset($priority['min']) ? $priority['min'] : null;
        $max = isset($priority['max']) ? $priority['max'] : null;

        $this->filterBuilder->andWhere(new PrioritySpecification($min, $max));
    }

    /**
     * @return void
     */
    public function buildHops()
    {
        if (!isset($this->criteria['hops'])) {
            return;
        }

        $hops = $this->criteria['hops'];

        if (!is_array($hops)) {
            $hops = array(
                'min' => $hops,
            );
        }

        $min = isset($hops['min']) ? $hops['min'] : null;
        $max = isset($hops['max']) ? $hops['max'] : null;

        $this->filterBuilder->andWhere(new HopsSpecification($min, $max));
    }

    /**
     * @return void
     */
    public function buildDelay()
    {
        if (!isset($this->criteria['delay'])) {
            return;
        }

        $delay = $this->criteria['delay'];

        if (!is_array($delay)) {
            $delay = array(
                'min' => $delay,
            );
        }

        $min = isset($delay['min']) ? $delay['min'] : null;
        $max = isset($delay['max']) ? $delay['max'] : null;

        $this->filterBuilder->andWhere(new DelaySpecification($min, $max));
    }

    /**
     * @return void
     */
    public function buildLife()
    {
        if (!isset($this->criteria['life'])) {
            return;
        }

        $life = $this->criteria['life'];

        if (!is_array($life)) {
            $life = array(
                'min' => $life,
            );
        }

        $min = isset($life['min']) ? $life['min'] : null;
        $max = isset($life['max']) ? $life['max'] : null;

        $this->filterBuilder->andWhere(new HopsSpecification($min, $max));
    }

    /**
     * @return void
     */
    public function buildLimit()
    {
        if (!isset($this->criteria['limit'])) {
            return;
        }

        $this->filterBuilder->setMaxResults($this->criteria['limit']);
    }

    /**
     * @return void
     */
    public function buildOrder()
    {
        if (!isset($this->criteria['order_by'])) {
            return;
        }

        $orderings = $this->criteria['order_by'];

        if (!is_array($orderings)) {
            $orderings = array(
                $orderings => FilterBuilder::ASC,
            );
        }

        $this->filterBuilder->orderBy($orderings);
    }

    /**
     * @return void
     */
    public function buildStamps()
    {
        if (!isset($this->criteria['stamps'])) {
            return;
        }

        $strategy = isset($this->criteria['stamps_strategy'])
            ? $this->criteria['stamps_strategy']
            : StampsSpecification::STRATEGY_OR;

        $this->filterBuilder->andWhere(new StampsSpecification($this->criteria['stamps'], $strategy));
    }

    /**
     * @return void
     */
    public function buildFilter()
    {
        if (!isset($this->criteria['filter'])) {
            return;
        }

        foreach ((array) $this->criteria['filter'] as $callback) {
            $this->filterBuilder->andWhere(new CallbackSpecification($this->filterBuilder, $callback));
        }
    }
}
