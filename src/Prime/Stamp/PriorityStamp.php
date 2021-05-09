<?php

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
     * @param mixed $orderable
     *
     * @return int
     */
    public function compare($orderable)
    {
        if (!$orderable instanceof self) {
            return 1;
        }

        return $this->priority - $orderable->priority;
    }

    public function toArray()
    {
        return array(
            'priority' => $this->getPriority(),
        );
    }
}
