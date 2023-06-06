<?php

namespace Flasher\Symfony\Template;

use Flasher\Prime\Template\TemplateEngineInterface;
use Twig\Environment;

final class TwigTemplateEngine implements TemplateEngineInterface
{
    /**
     * @var Environment
     */
    private $engine;

    public function __construct(Environment $engine)
    {
        $this->engine = $engine;
    }

    public function render($name, array $context = [])
    {
        return $this->engine->render($name, $context);
    }
}
