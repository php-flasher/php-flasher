<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Stamp;

final class WhenStamp implements StampInterface
{
    /**
     * @var bool
     */
    private $condition;

    /**
     * @param bool $condition
     */
    public function __construct($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return bool
     */
    public function getCondition()
    {
        return $this->condition;
    }
}
