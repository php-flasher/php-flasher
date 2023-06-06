<?php

namespace Flasher\Laravel\Template;

use Flasher\Prime\Template\TemplateEngineInterface;
use Illuminate\View\Factory;

final class BladeTemplateEngine implements TemplateEngineInterface
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

    public function render($name, array $context = [])
    {
        $view = $this->engine->make($name, $context);

        return $view->render();
    }
}
