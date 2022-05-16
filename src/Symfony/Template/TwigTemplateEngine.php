<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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

    public function render($name, array $context = array())
    {
        return $this->engine->render($name, $context);
    }
}
