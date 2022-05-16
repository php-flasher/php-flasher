<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Stamp;

use DateTime;
use DateTimeZone;
use Exception;

final class CreatedAtStamp implements StampInterface, OrderableStampInterface, PresentableStampInterface
{
    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $format;

    /**
     * @param string|null $format
     *
     * @throws Exception
     */
    public function __construct(DateTime $createdAt = null, $format = null)
    {
        $this->createdAt = $createdAt ?: new DateTime('now', new DateTimeZone('Africa/Casablanca'));
        $this->format = $format ?: 'Y-m-d H:i:s';
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function compare($orderable)
    {
        if (!$orderable instanceof self) {
            return 1;
        }

        return $this->createdAt->getTimestamp() - $orderable->createdAt->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $createdAt = $this->getCreatedAt();

        return array('created_at' => $createdAt->format($this->format));
    }
}
