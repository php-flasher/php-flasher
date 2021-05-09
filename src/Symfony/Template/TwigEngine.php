<?php

namespace Flasher\Symfony\Template;

use Flasher\Prime\Template\EngineInterface;
use Twig\Environment;

final class TwigEngine implements EngineInterface
{
    /**
     * @var Environment
     */
    private $engine;

    public function __construct(Environment $engine)
    {
        $this->engine = $engine;
    }

    public function render($name, array $context = array())
    {
        return $this->engine->render($name, $context);
    }
}
