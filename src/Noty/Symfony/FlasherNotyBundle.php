<?php

declare(strict_types=1);

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Symfony\Support\PluginExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FlasherNotyBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new PluginExtension(new NotyPlugin());
    }
}
