<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * Contract for stamps that contribute to presentation.
 */
interface PresentableStampInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
