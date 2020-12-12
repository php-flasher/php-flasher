<?php

namespace Flasher\Prime\Stamp;

interface OrderableStampInterface
{
    /**
     * @param mixed $orderable
     *
     * @return int
     */
    public function compare($orderable);
}
