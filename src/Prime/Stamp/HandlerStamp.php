<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array('handler' => $this->getHandler());
    }
}
