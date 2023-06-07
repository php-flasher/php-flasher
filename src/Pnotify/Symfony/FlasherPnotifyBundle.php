<?php

declare(strict_types=1);

namespace Flasher\Pnotify\Symfony;

use Flasher\Pnotify\Prime\PnotifyPlugin;
use Flasher\Symfony\Support\PluginExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FlasherPnotifyBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new PluginExtension(new PnotifyPlugin());
    }
}
