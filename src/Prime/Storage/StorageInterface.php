<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage;

use Flasher\Prime\Notification\Envelope;

interface StorageInterface
{
    /**
     * @return Envelope[]
     */
    public function all(): array;

    public function add(Envelope ...$envelopes): void;

    public function update(Envelope ...$envelopes): void;

    public function remove(Envelope ...$envelopes): void;

    public function clear(): void;
}
