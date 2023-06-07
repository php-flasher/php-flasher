<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

interface PresentableStampInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
