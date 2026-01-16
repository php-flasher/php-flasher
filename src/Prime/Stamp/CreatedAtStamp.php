<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class CreatedAtStamp implements OrderableStampInterface, PresentableStampInterface, StampInterface
{
    private \DateTimeImmutable $createdAt;

    private string $format;

    public function __construct(?\DateTimeImmutable $createdAt = null, ?string $format = null)
    {
        $this->createdAt = $createdAt ?: new \DateTimeImmutable();
        $this->format = $format ?: 'Y-m-d H:i:s';
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function compare(StampInterface $orderable): int
    {
        if (!$orderable instanceof self) {
            return 1;
        }

        return $this->createdAt->getTimestamp() - $orderable->createdAt->getTimestamp();
    }

    /**
     * @return array{created_at: string}
     */
    public function toArray(): array
    {
        return ['created_at' => $this->createdAt->format($this->format)];
    }
}
