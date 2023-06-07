<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

use Flasher\Prime\Notification\Envelope;

final class IdStamp implements StampInterface, PresentableStampInterface
{
    private string $id;

    public function __construct(string $id = null)
    {
        $this->id = $id ?? uniqid();
    }

    /**
     * @param  Envelope[]  $envelopes
     * @return array<string, Envelope>
     */
    public static function indexById(array $envelopes): array
    {
        $map = [];

        foreach ($envelopes as $envelope) {
            $stamp = $envelope->get(IdStamp::class);
            if (! $stamp instanceof self) {
                $stamp = new self();
                $envelope->withStamp($stamp);
            }

            $map[$stamp->getId()] = $envelope;
        }

        return $map;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array{id: string}
     */
    public function toArray(): array
    {
        return ['id' => $this->id];
    }
}
