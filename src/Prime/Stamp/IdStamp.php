<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

use Flasher\Prime\Notification\Envelope;

/**
 * IdStamp - Provides a unique identifier for notifications.
 *
 * This stamp assigns a unique identifier to each notification, which can be
 * used for referencing, tracking, or manipulating specific notifications. It
 * also provides utility methods for working with collections of notifications.
 *
 * Design patterns:
 * - Value Object: Immutable object representing a specific concept
 * - Identity: Provides a unique identifier for domain objects
 * - Collection Utility: Provides methods for working with notification collections
 */
final readonly class IdStamp implements PresentableStampInterface, StampInterface
{
    /**
     * The unique identifier.
     */
    private string $id;

    /**
     * Creates a new IdStamp instance.
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
     * This method attempts to use cryptographically secure random bytes for the ID,
     * with a fallback to uniqid() if random_bytes() fails.
     *
     * @return string The generated unique identifier
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
     * This utility method creates a map of envelopes keyed by their unique IDs,
     * adding IdStamps to envelopes that don't already have them.
     *
     * @param Envelope[] $envelopes An array of envelopes to index
     *
     * @return array<string, Envelope> An associative array of envelopes indexed by their ID
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
     * @return string The identifier
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Converts the stamp to an array representation.
     *
     * This method implements the serialization logic required by PresentableStampInterface.
     *
     * @return array{id: string} The array representation
     */
    public function toArray(): array
    {
        return ['id' => $this->id];
    }
}
