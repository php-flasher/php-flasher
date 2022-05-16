<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

final class PostRemoveEvent
{
    /**
     * @var Envelope[]
     */
    private $envelopesToRemove;

    /**
     * @var Envelope[]
     */
    private $envelopesToKeep;

    /**
     * @param Envelope[] $envelopesToRemove
     * @param Envelope[] $envelopesToKeep
     */
    public function __construct(array $envelopesToRemove = array(), array $envelopesToKeep = array())
    {
        $this->envelopesToRemove = $envelopesToRemove;
        $this->envelopesToKeep = $envelopesToKeep;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopesToRemove()
    {
        return $this->envelopesToRemove;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopesToKeep()
    {
        return $this->envelopesToKeep;
    }
}
