<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final class CreatedAtStamp implements StampInterface, OrderableStampInterface, PresentableStampInterface
{
    private readonly \DateTime $createdAt;

    private readonly string $format;

    /**
     * @throws \Exception
     */
    public function __construct(\DateTime $createdAt = null, string $format = null)
    {
        $this->createdAt = $createdAt ?: new \DateTime('now', new \DateTimeZone('Africa/Casablanca'));
        $this->format = $format ?: 'Y-m-d H:i:s';
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function compare(StampInterface $orderable): int
    {
        if (! $orderable instanceof self) {
            return 1;
        }

        return $this->createdAt->getTimestamp() - $orderable->createdAt->getTimestamp();
    }

    /**
     * @return array{created_at: string}
     */
    public function toArray(): array
    {
        $createdAt = $this->createdAt;

        return ['created_at' => $createdAt->format($this->format)];
    }
}
