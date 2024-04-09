<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

final class ArrayBag implements BagInterface
{
    /**
     * @var Envelope[]
     */
    private array $envelopes = [];

    public function get(): array
    {
        return $this->envelopes;
    }

    public function set(array $envelopes): void
    {
        $this->envelopes = $envelopes;
    }
}
