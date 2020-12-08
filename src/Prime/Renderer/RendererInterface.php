<?php

namespace Flasher\Prime\Renderer;

interface RendererInterface
{
    /**
     * @param array $criteria
     *
     * @return string
     */
    public function render(array $criteria = array());
}
