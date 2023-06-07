<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Storage\Bag\ArrayBag;
use Flasher\Prime\Storage\Bag\BagInterface;
use const PHP_SAPI;

final class StorageBag implements StorageInterface
{
    private readonly BagInterface $bag;

    public function __construct(BagInterface $bag = null)
    {
        $this->bag = $bag instanceof BagInterface && 'cli' !== PHP_SAPI ? $bag : new ArrayBag();
    }

    public function all(): array
    {
        return array_values($this->bag->get());
    }

    public function add(Envelope ...$envelopes): void
    {
        $envelopes = IdStamp::indexById($envelopes);
        $stored = IdStamp::indexById($this->all());
        $envelopes = [...$stored, ...$envelopes];

        $this->bag->set(array_values($envelopes));
    }

    public function update(Envelope ...$envelopes): void
    {
        $envelopes = IdStamp::indexById($envelopes);
        $stored = IdStamp::indexById($this->all());
        $envelopes = [...$stored, ...$envelopes];

        $this->bag->set(array_values($envelopes));
    }

    public function remove(Envelope ...$envelopes): void
    {
        $envelopes = IdStamp::indexById($envelopes);
        $stored = IdStamp::indexById($this->all());
        $envelopes = array_diff_key($stored, $envelopes);

        $this->bag->set(array_values($envelopes));
    }

    public function clear(): void
    {
        $this->bag->set([]);
    }
}
