<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;

final class StampsSpecification implements SpecificationInterface
{
    const STRATEGY_AND = 'and';
    const STRATEGY_OR = 'or';

    /**
     * @var array|string[]
     */
    private $stamps;

    /**
     * @var string
     */
    private $strategy;

    /**
     * @param string|string[] $stamps
     * @param string          $strategy
     */
    public function __construct($stamps, $strategy)
    {
        $this->stamps = (array) $stamps;
        $this->strategy = $strategy;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $diff = array_diff($this->stamps, array_keys($envelope->all()));

        if (self::STRATEGY_AND === $this->strategy) {
            return 0 === \count($diff);
        }

        return \count($diff) < \count($this->stamps);
    }
}
