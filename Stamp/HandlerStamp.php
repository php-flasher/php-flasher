<?php

namespace Flasher\Prime\Stamp;

final class HandlerStamp implements StampInterface
{
    /**
     * @var string
     */
    private $handler;

    /**
     * @param string $handler
     */
    public function __construct($handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return string
     */
    public function getHandler()
    {
        return $this->handler;
    }
}
