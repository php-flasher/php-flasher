<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Stamp;

final class ContextStamp implements StampInterface, PresentableStampInterface
{
    /**
     * @var mixed[]
     */
    private $context;

    /**
     * @param mixed[] $context
     */
    public function __construct(array $context)
    {
        $this->context = $context;
    }

    /**
     * @return mixed[]
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array('context' => $this->getContext());
    }
}
