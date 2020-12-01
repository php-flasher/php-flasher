<?php

namespace Flasher\Prime\TestsRenderer;

use Notify\Envelope;

interface RendererInterface
{
    /**
     * @param \Notify\Envelope $envelope
     *
     * @return string
     */
    public function render(Envelope $envelope);
}
