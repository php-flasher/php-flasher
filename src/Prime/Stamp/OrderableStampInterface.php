<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

interface OrderableStampInterface
{
    public function compare(StampInterface $orderable): int;
}
