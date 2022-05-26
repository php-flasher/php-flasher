<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

final class PresentationEvent
{
    /**
     * @var Envelope[]
     */
    private $envelopes;

    /**
     * @var mixed[]
     */
    private $context;

    /**
     * @param Envelope[] $envelopes
     * @param mixed[]    $context
     */
    public function __construct(array $envelopes, array $context)
    {
        $this->envelopes = $envelopes;
        $this->context = $context;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes()
    {
        return $this->envelopes;
    }

    /**
     * @return mixed[]
     */
    public function getContext()
    {
        return $this->context;
    }
}
