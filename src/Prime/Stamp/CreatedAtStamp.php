<?php

namespace Flasher\Prime\Stamp;

use DateTime;
use DateTimeZone;
use Exception;

final class CreatedAtStamp implements StampInterface, OrderableStampInterface
{
    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @param DateTime|null $createdAt
     *
     * @throws Exception
     */
    public function __construct(DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt ?: new DateTime('now', new DateTimeZone('Africa/Casablanca'));
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $orderable
     *
     * @return int
     */
    public function compare($orderable)
    {
        if (!$orderable instanceof CreatedAtStamp) {
            return 1;
        }

        return $this->createdAt->getTimestamp() - $orderable->createdAt->getTimestamp();
    }
}
