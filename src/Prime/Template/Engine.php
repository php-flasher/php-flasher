<?php

namespace Flasher\Prime\Template;

final class Engine implements EngineInterface
{
    public function render($name, array $context = array())
    {
        return 'cute template';
    }
}
