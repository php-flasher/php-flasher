<?php

declare(strict_types=1);

namespace Flasher\Laravel\Template;

use Flasher\Prime\Template\TemplateEngineInterface;
use Illuminate\View\Factory;

final class BladeTemplateEngine implements TemplateEngineInterface
{
    /**
     * @param Factory $engine
     */
    public function __construct(private $engine)
    {
    }

    public function render($name, array $context = [])
    {
        $view = $this->engine->make($name, $context);

        return $view->render();
    }
}
