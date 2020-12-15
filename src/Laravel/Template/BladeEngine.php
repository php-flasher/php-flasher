<?php

namespace Flasher\Laravel\Template;

use Flasher\Prime\Template\EngineInterface;

final class BladeEngine implements EngineInterface
{
    /**
     * @var
     */
    private $engine;

    /**
     * @param  $engine
     */
    public function __construct($engine)
    {
        $this->engine = $engine;
    }

    /**
     * @inheritDoc
     */
    public function render($name, array $context = array())
    {
        return (string) $this->engine->make($name, $context);
    }
}
