<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * Contract for stamps that affect notification ordering.
 */
interface OrderableStampInterface
{
    public function compare(StampInterface $orderable): int;
}
