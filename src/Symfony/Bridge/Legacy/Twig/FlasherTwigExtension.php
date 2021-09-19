<?php

namespace Flasher\Symfony\Bridge\Legacy\Twig;

use Twig\Extension\AbstractExtension;

abstract class FlasherTwigExtension extends AbstractExtension
{
    /**
     * @return array
     */
    abstract protected function getFlasherFunctions();

    public function getFunctions()
    {
        return $this->getFlasherFunctions();
    }
}
