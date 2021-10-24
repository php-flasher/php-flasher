<?php

namespace Flasher\Prime\Filter;

use Flasher\Prime\Envelope;
use Flasher\Prime\Filter\Specification\AndSpecification;
use Flasher\Prime\Filter\Specification\OrSpecification;
use Flasher\Prime\Filter\Specification\SpecificationInterface;
use Flasher\Prime\Stamp\OrderableStampInterface;
use Flasher\Prime\Stamp\StampInterface;

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

    /** @var array<string, string> */
    private static $stampsMap = array(
        'priority' => 'Flasher\Prime\Stamp\PriorityStamp',
        'created_at' => 'Flasher\Prime\Stamp\CreatedAtStamp',
        'delay' => 'Flasher\Prime\Stamp\DelayStamp',
        'hops' => 'Flasher\Prime\Stamp\HopsStamp',
    );

    /**
     * @param Envelope[] $envelopes
     *
     * @return Envelope[]
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
                /**
                 * @var class-string<StampInterface> $field
                 * @var string $ordering
                 */
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
     * @param array<string, mixed> $criteria
     *
     * @return self
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
        $this->orderings = array_map(function ($ordering) {
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
     * @return self
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;

        return $this;
    }

    /**
     * @return self
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
     * @return self
     */
    public function where(SpecificationInterface $specification)
    {
        $this->specification = $specification;

        return $this;
    }

    /**
     * @return self
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
