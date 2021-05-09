<?php

namespace Flasher\Prime\Template;

interface EngineInterface
{
    /**
     * @param string $name
     *
     * @return string
     */
    public function render($name, array $context = array());
}
