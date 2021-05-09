<?php

namespace Flasher\Prime\Filter;

final class Filter implements FilterInterface
{
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(FilterBuilder $filterBuilder = null)
    {
        $this->filterBuilder = $filterBuilder ?: new FilterBuilder();
    }

    public function filter(array $envelopes, array $criteria)
    {
        return $this->filterBuilder->withCriteria($criteria)->filter($envelopes);
    }
}
