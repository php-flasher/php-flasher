<?php

namespace Flasher\Prime\Filter;

final class Filter implements FilterInterface
{
    public function filter(array $envelopes, array $criteria)
    {
        $filterBuilder = new FilterBuilder();
        $filterBuilder->withCriteria($criteria);

        return $filterBuilder->filter($envelopes);
    }
}
