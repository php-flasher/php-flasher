<?php

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

final class RemoveEvent
{
    /**
     * @var Envelope[]
     */
    private $envelopesToRemove = [];

    /**
     * @var Envelope[]
     */
    private $envelopesToKeep = [];

    /**
     * @param Envelope[] $envelopesToRemove
     */
    public function __construct(array $envelopesToRemove)
    {
        $this->envelopesToRemove = $envelopesToRemove;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopesToRemove()
    {
        return $this->envelopesToRemove;
    }

    /**
     * @param Envelope[] $envelopesToRemove
     *
     * @return void
     */
    public function setEnvelopesToRemove($envelopesToRemove)
    {
        $this->envelopesToRemove = $envelopesToRemove;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopesToKeep()
    {
        return $this->envelopesToKeep;
    }

    /**
     * @param Envelope[] $envelopesToKeep
     *
     * @return void
     */
    public function setEnvelopesToKeep($envelopesToKeep)
    {
        $this->envelopesToKeep = $envelopesToKeep;
    }
}
