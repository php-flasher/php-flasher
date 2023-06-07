<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter;

use Flasher\Prime\Filter\Specification\AndSpecification;
use Flasher\Prime\Filter\Specification\SpecificationInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\OrderableStampInterface;
use Flasher\Prime\Stamp\StampInterface;

final class Filter
{
    /**
     * @var string
     */
    public const ASC = 'ASC';

    /**
     * @var string
     */
    public const DESC = 'DESC';

    private \Flasher\Prime\Filter\Specification\AndSpecification|\Flasher\Prime\Filter\Specification\SpecificationInterface|null $specification = null;

    /**
     * @var array<string, string>
     */
    private array $orderings = [];

    /**
     * @var int|null
     */
    private $maxResults;

    /**
     * @param  Envelope[]  $envelopes
     * @param  array<string, mixed>  $criteria
     */
    public function __construct(private array $envelopes, private readonly array $criteria)
    {
    }

    /**
     * @return Envelope[]
     */
    public function getResult(): array
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
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    public function addSpecification(SpecificationInterface $specification): void
    {
        $this->specification = $this->specification instanceof \Flasher\Prime\Filter\Specification\SpecificationInterface
            ? new AndSpecification($this->specification, $specification)
            : $specification;
    }

    /**
     * @param  array<string, string>  $orderings
     */
    public function orderBy(array $orderings): void
    {
        $this->orderings = $orderings;
    }

    /**
     * @param  int  $maxResults
     */
    public function setMaxResults($maxResults): void
    {
        $this->maxResults = $maxResults;
    }

    private function applySpecification(): void
    {
        if (! $this->specification instanceof \Flasher\Prime\Filter\Specification\SpecificationInterface) {
            return;
        }

        $specification = $this->specification;
        $this->envelopes = array_filter($this->envelopes, static fn (Envelope $envelope): bool => $specification->isSatisfiedBy($envelope));
    }

    private function applyOrdering(): void
    {
        if ([] === $this->orderings) {
            return;
        }

        $orderings = $this->orderings;
        usort($this->envelopes, static function (Envelope $first, Envelope $second) use ($orderings): int {
            /**
             * @var class-string<StampInterface> $field
             * @var string                       $ordering
             */
            foreach ($orderings as $field => $ordering) {
                $stampA = $first->get($field);
                $stampB = $second->get($field);

                if (! $stampA instanceof OrderableStampInterface || ! $stampB instanceof OrderableStampInterface) {
                    return 0;
                }

                if (self::ASC === $ordering) {
                    return $stampA->compare($stampB);
                }

                return $stampB->compare($stampA);
            }

            return 0;
        });
    }

    private function applyLimit(): void
    {
        if (null === $this->maxResults) {
            return;
        }

        $this->envelopes = \array_slice($this->envelopes, 0, $this->maxResults, true);
    }
}
