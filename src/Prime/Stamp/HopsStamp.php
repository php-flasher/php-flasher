<?php

namespace Flasher\Prime\Stamp;

final class HopsStamp implements StampInterface
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @param int $amount
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
