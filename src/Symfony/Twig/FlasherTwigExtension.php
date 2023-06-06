<?php

namespace Flasher\Symfony\Twig;

use Flasher\Symfony\Bridge\Twig\FlasherTwigExtension as BaseFlasherTwigExtension;
use Twig\TwigFunction;

final class FlasherTwigExtension extends BaseFlasherTwigExtension
{
    /**
     * @return TwigFunction[]
     */
    public function getFlasherFunctions()
    {
        return [
            new TwigFunction('flasher_render', [$this, 'render']),
        ];
    }

    /**
     * @return string
     */
    public function render()
    {
        return '';
    }
}
