<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Storage\Bag\BagInterface;

final readonly class Storage implements StorageInterface
{
    public function __construct(private BagInterface $bag)
    {
    }

    public function all(): array
    {
        return array_values($this->bag->get());
    }

    public function add(Envelope ...$envelopes): void
    {
        $this->save(...$envelopes);
    }

    public function update(Envelope ...$envelopes): void
    {
        $this->save(...$envelopes);
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

    private function save(Envelope ...$envelopes): void
    {
        $envelopes = IdStamp::indexById($envelopes);
        $stored = IdStamp::indexById($this->all());
        $envelopes = [...$stored, ...$envelopes];

        $this->bag->set(array_values($envelopes));
    }
}
