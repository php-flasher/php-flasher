<?php

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Envelope;

final class PostRemoveEvent
{
    /**
     * @var Envelope[]
     */
    private $envelopesToRemove = array();

    /**
     * @var Envelope[]
     */
    private $envelopesToKeep = array();

    /**
     * @param Envelope[] $envelopesToRemove
     */
    public function __construct(array $envelopesToRemove, array $envelopesToKeep)
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
