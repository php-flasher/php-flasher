<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Filter;

use Flasher\Prime\Filter\Specification\AndSpecification;
use Flasher\Prime\Filter\Specification\SpecificationInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\OrderableStampInterface;
use Flasher\Prime\Stamp\StampInterface;

final class Filter
{
    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * @var Envelope[]
     */
    private $envelopes;

    /**
     * @var array<string, mixed>
     */
    private $criteria;

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

    /**
     * @param Envelope[]           $envelopes
     * @param array<string, mixed> $criteria
     */
    public function __construct(array $envelopes, array $criteria)
    {
        $this->envelopes = $envelopes;
        $this->criteria = $criteria;
    }

    /**
     * @return Envelope[]
     */
    public function getResult()
    {
        $criteriaBuilder = new CriteriaBuilder($this, $this->criteria);
        $criteriaBuilder->build();

        $this->applySpecification();
        $this->applyOrdering();
        $this->applyLimit();

        return array_values($this->envelopes);
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes()
    {
        return $this->envelopes;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @return void
     */
    public function addSpecification(SpecificationInterface $specification)
    {
        $this->specification = null !== $this->specification
            ? new AndSpecification($this->specification, $specification)
            : $specification;
    }

    /**
     * @param array<string, string> $orderings
     *
     * @return void
     */
    public function orderBy(array $orderings)
    {
        $this->orderings = $orderings;
    }

    /**
     * @param int $maxResults
     *
     * @return void
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
    }

    /**
     * @return void
     */
    private function applySpecification()
    {
        if (null === $this->specification) {
            return;
        }

        $specification = $this->specification;
        $this->envelopes = array_filter($this->envelopes, function (Envelope $envelope) use ($specification) {
            return $specification->isSatisfiedBy($envelope);
        });
    }

    /**
     * @return void
     */
    private function applyOrdering()
    {
        if (array() === $this->orderings) {
            return;
        }

        $orderings = $this->orderings;
        usort($this->envelopes, function (Envelope $first, Envelope $second) use ($orderings) {
            /**
             * @var class-string<StampInterface> $field
             * @var string                       $ordering
             */
            foreach ($orderings as $field => $ordering) {
                $stampA = $first->get($field);
                $stampB = $second->get($field);

                if (!$stampA instanceof OrderableStampInterface || !$stampB instanceof OrderableStampInterface) {
                    return 0;
                }

                if (Filter::ASC === $ordering) {
                    return $stampA->compare($stampB);
                }

                return $stampB->compare($stampA);
            }

            return 0;
        });
    }

    /**
     * @return void
     */
    private function applyLimit()
    {
        if (null === $this->maxResults) {
            return;
        }

        $this->envelopes = \array_slice($this->envelopes, 0, $this->maxResults, true);
    }
}
