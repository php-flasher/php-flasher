<?php

namespace Flasher\Prime\Stamp;

interface OrderableStampInterface
{
    /**
     * @param OrderableStampInterface $orderable
     *
     * @return int
     */
    public function compare($orderable);
}
