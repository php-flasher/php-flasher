<?php

declare(strict_types=1);

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\FlasherBundleInterface;
use Flasher\Symfony\Support\PluginExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FlasherNotyBundle extends Bundle implements FlasherBundleInterface
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new PluginExtension($this->createPlugin());
    }

    public function createPlugin(): PluginInterface
    {
        return new NotyPlugin();
    }
}
