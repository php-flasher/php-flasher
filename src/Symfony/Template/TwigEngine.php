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

    /**
     * @param Environment $engine
     */
    public function __construct(Environment $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @inheritDoc
     */
    public function render($name, array $context = array())
    {
        return $this->engine->render($name, $context);
    }
}
