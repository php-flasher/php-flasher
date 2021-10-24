<?php

namespace Flasher\Laravel\Template;

use Flasher\Prime\Template\EngineInterface;
use Illuminate\View\Factory;

final class BladeEngine implements EngineInterface
{
    /**
     * @var Factory
     */
    private $engine;

    /**
     * @param Factory $engine
     */
    public function __construct($engine)
    {
        $this->engine = $engine;
    }

    public function render($name, array $context = array())
    {
        $view = $this->engine->make($name, $context);

        return $view->render();
    }
}
