<?php

namespace Flasher\Prime\Stamp;

final class CreatedAtStamp implements StampInterface, OrderableStampInterface, PresentableStampInterface
{
    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $format;

    /**
     * @param string|null $format
     *
     * @throws \Exception
     */
    public function __construct(\DateTime $createdAt = null, $format = null)
    {
        $this->createdAt = $createdAt ?: new \DateTime('now', new \DateTimeZone('Africa/Casablanca'));
        $this->format = $format ?: 'Y-m-d H:i:s';
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function compare($orderable)
    {
        if (!$orderable instanceof self) {
            return 1;
        }

        return $this->createdAt->getTimestamp() - $orderable->createdAt->getTimestamp();
    }

    public function toArray()
    {
        $createdAt = $this->getCreatedAt();

        return ['created_at' => $createdAt->format($this->format)];
    }
}
