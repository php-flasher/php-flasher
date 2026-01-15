<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

/**
 * Contract for notification envelope storage containers.
 */
interface BagInterface
{
    /**
     * @return Envelope[]
     */
    public function get(): array;

    /**
     * @param Envelope[] $envelopes
     */
    public function set(array $envelopes): void;
}
