<?php

namespace Flasher\Prime\Stamp;

final class HandlerStamp implements StampInterface, PresentableStampInterface
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

    public function toArray()
    {
        return array(
            'handler' => $this->getHandler(),
        );
    }
}
