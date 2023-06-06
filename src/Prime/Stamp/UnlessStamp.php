<?php

namespace Flasher\Prime\Stamp;

final class UnlessStamp implements StampInterface
{
    /**
     * @var bool
     */
    private $condition;

    /**
     * @param bool $condition
     */
    public function __construct($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return bool
     */
    public function getCondition()
    {
        return $this->condition;
    }
}
