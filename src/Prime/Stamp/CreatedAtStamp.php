<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class CreatedAtStamp implements OrderableStampInterface, PresentableStampInterface, StampInterface
{
    private \DateTimeImmutable $createdAt;

    private string $format;

    /**
     * @param \DateTimeImmutable|null $createdAt the datetime object representing the creation time
     * @param string|null             $format    the format in which the datetime should be presented
     */
    public function __construct(?\DateTimeImmutable $createdAt = null, ?string $format = null)
    {
        $this->createdAt = $createdAt ?: new \DateTimeImmutable();
        $this->format = $format ?: 'Y-m-d H:i:s';
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Compares the current stamp with another orderable stamp.
     *
     * @param StampInterface $orderable the stamp to compare with
     *
     * @return int returns less than 0 if current is less than the given stamp,
     *             greater than 0 if current is greater
     *             and 0 if they are equal
     */
    public function compare(StampInterface $orderable): int
    {
        if (!$orderable instanceof self) {
            return 1;
        }

        return $this->createdAt->getTimestamp() - $orderable->createdAt->getTimestamp();
    }

    /**
     * @return array{created_at: string} returns an associative array representation of the stamp
     */
    public function toArray(): array
    {
        return ['created_at' => $this->createdAt->format($this->format)];
    }
}
