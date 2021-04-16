<?php

namespace Flasher\Prime\Template;

final class Engine implements EngineInterface
{
    public function render($name, array $context = array())
    {
        /** @TODO use a native template engine */
        return 'template ' . $name;
    }
}
