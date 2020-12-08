<?php

namespace Flasher\Prime\Filter;

use Flasher\Prime\Envelope;

final class DefaultFilter implements FilterInterface
{
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(FilterBuilder $filterBuilder)
    {
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * @param Envelope[] $envelopes
     * @param array      $criteria
     *
     * @return array
     */
    public function filter($envelopes, $criteria = array())
    {
        return $this->filterBuilder->withCriteria($criteria)->filter($envelopes);
    }
}
