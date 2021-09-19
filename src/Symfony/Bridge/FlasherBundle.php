<?php

namespace Flasher\Symfony\Bridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

if (Bridge::isLegacy()) {
    class_alias('Flasher\Symfony\Bridge\Legacy\FlasherBundle', 'Flasher\Symfony\Bridge\FlasherBundle');
} else {
    abstract class FlasherBundle extends Bundle
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
        abstract protected function getFlasherContainerExtension();

        public function build(ContainerBuilder $container)
        {
            $this->flasherBuild($container);
        }

        public function getContainerExtension(): ?ExtensionInterface
        {
            return $this->getFlasherContainerExtension();
        }
    }
}
