<?php

namespace Flasher\Prime\Filter;

use Flasher\Prime\Envelope;
use Flasher\Prime\Filter\Specification\AndSpecification;
use Flasher\Prime\Filter\Specification\OrSpecification;
use Flasher\Prime\Filter\Specification\SpecificationInterface;
use Flasher\Prime\Stamp\OrderableStampInterface;

final class FilterBuilder
{
    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * @var SpecificationInterface
     */
    private $specification;

    /**
     * @var array<string, string>
     */
    private $orderings = array();

    /**
     * @var int|null
     */
    private $maxResults;

    private static $stampsMap = array(
        'priority' => 'Flasher\Prime\Stamp\PriorityStamp',
        'created_at' => 'Flasher\Prime\Stamp\CreatedAtStamp',
        'delay' => 'Flasher\Prime\Stamp\DelayStamp',
        'hops' => 'Flasher\Prime\Stamp\HopsStamp',
    );

    /**
     * @param Envelope[] $envelopes
     *
     * @return array
     */
    public function filter(array $envelopes)
    {
        $specification = $this->getSpecification();

        if (null !== $specification) {
            $envelopes = array_filter($envelopes, function (Envelope $envelope) use ($specification) {
                return $specification->isSatisfiedBy($envelope);
            });
        }

        $orderings = $this->getOrderings();

        if (null !== $orderings) {
            usort($envelopes, function (Envelope $a, Envelope $b) use ($orderings) {
                foreach ($orderings as $field => $ordering) {
                    if (FilterBuilder::ASC !== $ordering) {
                        list($a, $b) = array($b, $a);
                    }

                    // if (isset(FilterBuilder::$stampsMap[$field])) {
                    //     return FilterBuilder::$stampsMap[$field];
                    // }

                    $stampA = $a->get($field);
                    $stampB = $b->get($field);

                    if (!$stampA instanceof OrderableStampInterface) {
                        return -1;
                    }

                    if (!$stampB instanceof OrderableStampInterface) {
                        return 1;
                    }

                    return $stampA->compare($stampB);
                }

                return 0;
            });
        }

        $length = $this->getMaxResults();

        if (null !== $length) {
            $envelopes = array_slice($envelopes, 0, $length, true);
        }

        return $envelopes;
    }

    /**
     * @return $this
     */
    public function withCriteria(array $criteria)
    {
        $criteriaBuilder = new CriteriaBuilder($this, $criteria);
        $criteriaBuilder->build();

        return $this;
    }

    /**
     * @param array<string, string> $orderings
     *
     * @return self
     */
    public function orderBy(array $orderings)
    {
        $this->orderings = array_map(static function ($ordering) {
            return strtoupper($ordering) === FilterBuilder::ASC ? FilterBuilder::ASC : FilterBuilder::DESC;
        }, $orderings);

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getOrderings()
    {
        return $this->orderings;
    }

    /**
     * @return SpecificationInterface
     */
    public function getSpecification()
    {
        return $this->specification;
    }

    /**
     * @return int|null
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * @param int $maxResults
     *
     * @return $this
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;

        return $this;
    }

    /**
     * @return $this
     */
    public function andWhere(SpecificationInterface $specification)
    {
        if ($this->specification === null) {
            return $this->where($specification);
        }

        $this->specification = new AndSpecification($this->specification, $specification);

        return $this;
    }

    /**
     * @return $this
     */
    public function where(SpecificationInterface $specification)
    {
        $this->specification = $specification;

        return $this;
    }

    /**
     * @return $this
     */
    public function orWhere(SpecificationInterface $specification)
    {
        if ($this->specification === null) {
            return $this->where($specification);
        }

        $this->specification = new OrSpecification($this->specification, $specification);

        return $this;
    }
}
