<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Stamp;

final class DelayStamp implements StampInterface
{
    /**
     * @var int
     */
    private $delay;

    /**
     * @param int $delay
     */
    public function __construct($delay)
    {
        $this->delay = $delay;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }
}
