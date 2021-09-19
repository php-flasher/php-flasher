<?php

namespace Flasher\Symfony\Bridge\Twig;

use Flasher\Symfony\Bridge\Bridge;
use Twig\Extension\AbstractExtension;

if (Bridge::isLegacy()) {
    class_alias('Flasher\Symfony\Bridge\Legacy\Twig\FlasherTwigExtension', 'Flasher\Symfony\Bridge\Twig\FlasherTwigExtension');
} else {
    abstract class FlasherTwigExtension extends AbstractExtension
    {
        /**
         * @return array
         */
        abstract protected function getFlasherFunctions();

        public function getFunctions(): array
        {
            return $this->getFlasherFunctions();
        }
    }
}
