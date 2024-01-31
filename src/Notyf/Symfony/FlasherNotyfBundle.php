<?php

declare(strict_types=1);

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Prime\NotyfPlugin;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\FlasherBundleInterface;
use Flasher\Symfony\Support\PluginExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FlasherNotyfBundle extends Bundle implements FlasherBundleInterface
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new PluginExtension($this->createPlugin());
    }

    public function createPlugin(): PluginInterface
    {
        return new NotyfPlugin();
    }
}
