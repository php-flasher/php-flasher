<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

use Flasher\Prime\Notification\Envelope;

final readonly class IdStamp implements PresentableStampInterface, StampInterface
{
    private string $id;

    public function __construct(?string $id = null)
    {
        $this->id = $id ?? $this->generateUniqueId();
    }

    private function generateUniqueId(): string
    {
        try {
            return bin2hex(random_bytes(16));
        } catch (\Random\RandomException) {
            return uniqid('', true);
        }
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return array<string, Envelope>
     */
    public static function indexById(array $envelopes): array
    {
        $map = [];

        foreach ($envelopes as $envelope) {
            $stamp = $envelope->get(self::class);
            if ($stamp instanceof self) {
                $map[$stamp->getId()] = $envelope;
                continue;
            }

            $newStamp = new self();
            $envelope->withStamp($newStamp);
            $map[$newStamp->getId()] = $envelope;
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
