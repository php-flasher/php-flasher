<?php

namespace Flasher\Symfony\Bridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

$class = Bridge::isLegacy()
    ? 'Flasher\Symfony\Bridge\Legacy\FlasherBundle'
    : 'Flasher\Symfony\Bridge\Typed\FlasherBundle';

class_alias($class, 'Flasher\Symfony\Bridge\FlasherBundle');

if (false) { /** @phpstan-ignore-line */
    abstract class FlasherBundle
    {
        /**
         * @return void
         */
        protected function flasherBuild(ContainerBuilder $container)
        {
        }

        /**
         * @return ?ExtensionInterface
         */
        protected function getFlasherContainerExtension()
        {
            return null;
        }
    }
}
