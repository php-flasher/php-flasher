<?php

namespace Flasher\Prime\Renderer;

use Flasher\Prime\Envelope;

interface RendererInterface
{
    /**
     * @param Envelope $envelope
     *
     * @return string
     */
    public function render(Envelope $envelope);
}
