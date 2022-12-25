<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Aware;

use Flasher\Prime\FlasherInterface;

trait FlasherAwareTrait
{
    /**
     * @var FlasherInterface
     */
    protected $flasher;

    public function setFlasher(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }
}
