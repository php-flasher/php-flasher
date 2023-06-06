<?php

namespace Flasher\Prime\Stamp;

interface OrderableStampInterface
{
    /**
     * @return int
     */
    public function compare($orderable);
}
