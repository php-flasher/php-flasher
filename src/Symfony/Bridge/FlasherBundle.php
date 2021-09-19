<?php

namespace Flasher\Symfony\Bridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

if (Bridge::isLegacy()) {
    class_alias('Flasher\Symfony\Bridge\Legacy\FlasherBundle', 'Flasher\Symfony\Bridge\FlasherBundle');
} else {
    class_alias('Flasher\Symfony\Bridge\Typed\FlasherBundle', 'Flasher\Symfony\Bridge\FlasherBundle');
}

if (false) {
    abstract class FlasherBundle {}
}
