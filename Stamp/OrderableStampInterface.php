<?php

namespace Flasher\Prime\Stamp;

interface OrderableStampInterface
{
    /**
     * @param mixed $orderable
     *
     * @return bool
     */
    public function compare($orderable);
}
