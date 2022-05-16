<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Stamp;

final class PriorityStamp implements StampInterface, OrderableStampInterface, PresentableStampInterface
{
    /**
     * @var int
     */
    private $priority;

    /**
     * @param int $priority
     */
    public function __construct($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * {@inheritdoc}
     */
    public function compare($orderable)
    {
        if (!$orderable instanceof self) {
            return 1;
        }

        return $this->priority - $orderable->priority;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array('priority' => $this->getPriority());
    }
}
