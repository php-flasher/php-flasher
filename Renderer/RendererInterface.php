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

    /**
     * @param string $name
     * @param array $context
     *
     * @return bool
     */
    public function supports($name = null, array $context = array());
}
