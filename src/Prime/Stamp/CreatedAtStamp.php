<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * CreatedAtStamp - Records when a notification was created.
 *
 * This stamp stores the creation time of a notification, which can be used
 * for ordering, filtering, or display purposes. It implements OrderableStampInterface
 * to enable sorting notifications by creation time.
 *
 * Design patterns:
 * - Value Object: Immutable object representing a specific concept
 * - Temporal Marker: Records a point in time for domain objects
 * - Comparable: Implements comparison logic for time-based sorting
 */
final readonly class CreatedAtStamp implements OrderableStampInterface, PresentableStampInterface, StampInterface
{
    /**
     * The creation timestamp.
     */
    private \DateTimeImmutable $createdAt;

    /**
     * The format string for date presentation.
     */
    private string $format;

    /**
     * Creates a new CreatedAtStamp instance.
     *
     * @param \DateTimeImmutable|null $createdAt The datetime object representing the creation time
     * @param string|null             $format    The format in which the datetime should be presented
     */
    public function __construct(?\DateTimeImmutable $createdAt = null, ?string $format = null)
    {
        $this->createdAt = $createdAt ?: new \DateTimeImmutable();
        $this->format = $format ?: 'Y-m-d H:i:s';
    }

    /**
     * Gets the creation timestamp.
     *
     * @return \DateTimeImmutable The creation timestamp
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Compares this stamp with another for ordering purposes.
     *
     * This method implements the comparison logic required by OrderableStampInterface.
     * It orders notifications chronologically by creation time.
     *
     * @param StampInterface $orderable The stamp to compare with
     *
     * @return int Negative if this is older, positive if newer, zero if same time
     */
    public function compare(StampInterface $orderable): int
    {
        if (!$orderable instanceof self) {
            return 1;
        }

        return $this->createdAt->getTimestamp() - $orderable->createdAt->getTimestamp();
    }

    /**
     * Converts the stamp to an array representation.
     *
     * This method implements the serialization logic required by PresentableStampInterface.
     *
     * @return array{created_at: string} The array representation with formatted timestamp
     */
    public function toArray(): array
    {
        return ['created_at' => $this->createdAt->format($this->format)];
    }
}
