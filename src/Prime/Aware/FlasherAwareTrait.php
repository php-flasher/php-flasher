<?php

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
