<?php

namespace Flasher\Prime\TestsStamp;

interface OrderableStampInterface
{
    /**
     * @param \Flasher\Prime\TestsStamp\OrderableStampInterface $orderable
     *
     * @return int
     */
    public function compare($orderable);
}
