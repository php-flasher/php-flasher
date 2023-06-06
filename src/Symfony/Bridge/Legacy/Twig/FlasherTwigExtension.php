<?php

namespace Flasher\Symfony\Bridge\Legacy\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

abstract class FlasherTwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return $this->getFlasherFunctions();
    }

    /**
     * @return TwigFunction[]
     */
    abstract protected function getFlasherFunctions();
}
