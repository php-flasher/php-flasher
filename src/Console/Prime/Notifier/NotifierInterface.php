<?php

namespace Flasher\Console\Prime\Notifier;

use Flasher\Prime\Envelope;

interface NotifierInterface
{
    /**
     * @param Envelope[] $envelopes
     */
    public function render(array $envelopes, $firstTime = true);

    /**
     * @return bool
     */
    public function isSupported();

    /**
     * @return int
     */
    public function getPriority();

    /**
     * @return string
     */
    public function getBinary();
}
