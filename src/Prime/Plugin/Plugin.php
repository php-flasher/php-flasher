<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

abstract class Plugin implements PluginInterface
{
    public function getName(): string
    {
        return 'flasher_'.$this->getAlias();
    }

    public function getServiceId(): string
    {
        return 'flasher.'.$this->getAlias();
    }

    public function getServiceAliases(): string|array
    {
        return [];
    }

    public function getScripts(): string|array
    {
        return [];
    }

    public function getStyles(): string|array
    {
        return [];
    }

    public function getOptions(): array
    {
        return [];
    }

    public function getAssetsDir(): string
    {
        $resourcesDir = $this->getResourcesDir();
        $assetsDir = rtrim($resourcesDir, '/').'/public/';

        return realpath($assetsDir) ?: '';
    }

    public function getResourcesDir(): string
    {
        $reflection = new \ReflectionClass($this);
        $pluginDir = pathinfo($reflection->getFileName() ?: '', \PATHINFO_DIRNAME);
        $resourcesDir = is_dir($pluginDir.'/Resources/')
            ? $pluginDir.'/Resources/'
            : $pluginDir.'/../Resources/';

        return realpath($resourcesDir) ?: '';
    }

    public function normalizeConfig(array $config): array
    {
        $config = [
            'scripts' => $this->getScripts(),
            'styles' => $this->getStyles(),
            'options' => $this->getOptions(),
            ...$config,
        ];

        $config['styles'] = (array) $config['styles'];
        $config['scripts'] = (array) $config['scripts'];

        return $config;
    }
}
