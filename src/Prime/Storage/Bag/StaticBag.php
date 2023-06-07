<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

final class StaticBag implements BagInterface
{
    /**
     * @var Envelope[]
     */
    private static array $envelopes = [];

    public function get(): array
    {
        return self::$envelopes;
    }

    public function set(array $envelopes): void
    {
        self::$envelopes = $envelopes;
    }
}
