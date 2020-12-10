<?php

namespace Flasher\Prime\Renderer;

interface RendererInterface
{
    /**
     * @param array $criteria
     * @param array $context
     *
     * @return mixed
     */
    public function render(array $criteria = array(), array $context = array());
}
