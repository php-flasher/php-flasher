<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage;

use Flasher\Prime\Notification\Envelope;

interface StorageManagerInterface
{
    /**
     * @return Envelope[]
     */
    public function all(): array;

    /**
     * @param array<string, mixed> $criteria
     *
     * @return Envelope[]
     */
    public function filter(array $criteria = []): array;

    public function add(Envelope ...$envelopes): void;

    public function update(Envelope ...$envelopes): void;

    public function remove(Envelope ...$envelopes): void;

    public function clear(): void;
}
