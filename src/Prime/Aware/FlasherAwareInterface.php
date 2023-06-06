<?php

namespace Flasher\Prime\Aware;

use Flasher\Prime\FlasherInterface;

interface FlasherAwareInterface
{
    /**
     * @return void
     */
    public function setFlasher(FlasherInterface $flasher);
}
