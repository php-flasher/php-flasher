<?php

namespace Flasher\Symfony\Bridge\Twig;

use Flasher\Symfony\Bridge\Bridge;

if (Bridge::isLegacy()) {
    class_alias('Flasher\Symfony\Bridge\Legacy\Twig\FlasherTwigExtension', 'Flasher\Symfony\Bridge\Twig\FlasherTwigExtension');
} else {
    class_alias('Flasher\Symfony\Bridge\Typed\Twig\FlasherTwigExtension', 'Flasher\Symfony\Bridge\Twig\FlasherTwigExtension');
}

if (false) {
    abstract class FlasherTwigExtension {}
}
