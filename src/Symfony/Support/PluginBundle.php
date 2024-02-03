<?php

declare(strict_types=1);

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

abstract class PluginBundle extends Bundle implements PluginBundleInterface
{
    abstract public function createPlugin(): PluginInterface;

    public function getContainerExtension(): ExtensionInterface
    {
        return new PluginExtension($this->createPlugin());
    }

    public function getConfigurationFile(): string
    {
        return rtrim($this->getResourcesDir(), '/').'/config/config.yaml';
    }

    protected function getResourcesDir(): string
    {
        $r = new \ReflectionClass($this);

        return pathinfo($r->getFileName() ?: '', \PATHINFO_DIRNAME).'/Resources/';
    }
}
