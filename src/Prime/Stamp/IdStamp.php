<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

use Flasher\Prime\Notification\Envelope;

final readonly class IdStamp implements PresentableStampInterface, StampInterface
{
    private string $id;

    /**
     * Constructs an IdStamp with a unique identifier.
     *
     * @param string|null $id The identifier. If not provided, a unique identifier is generated.
     */
    public function __construct(?string $id = null)
    {
        $this->id = $id ?? $this->generateUniqueId();
    }

    /**
     * Generates a unique identifier.
     *
     * @return string the generated unique identifier
     */
    private function generateUniqueId(): string
    {
        try {
            return bin2hex(random_bytes(16));
        } catch (\Exception) {
            // Handle the exception or fallback to another method of ID generation
            // For example, using uniqid() as a fallback
            return uniqid('', true);
        }
    }

    /**
     * Indexes an array of envelopes by their ID.
     *
     * @param Envelope[] $envelopes an array of envelopes to index
     *
     * @return array<string, Envelope> an associative array of envelopes indexed by their ID
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

    /**
     * Gets the identifier.
     *
     * @return string the identifier
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Converts the stamp to an array.
     *
     * @return array{id: string} an associative array with the identifier
     */
    public function toArray(): array
    {
        return ['id' => $this->id];
    }
}
