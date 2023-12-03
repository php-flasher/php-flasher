<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

abstract class Plugin implements PluginInterface
{
    public function getAlias(): string
    {
        $alias = basename(str_replace('\\', '/', static::class));
        $alias = str_replace('Plugin', '', $alias);
        $alias = preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $alias) ?: '';

        return strtolower($alias);
    }

    public function getName(): string
    {
        return 'flasher_'.$this->getAlias();
    }

    public function getServiceID(): string
    {
        return 'flasher.factory_'.$this->getAlias();
    }

    public function getFactory(): string
    {
        return str_replace('Plugin', 'Factory', static::class); // @phpstan-ignore-line
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
        $assetsDir = rtrim($resourcesDir, '/').'/assets/';

        return realpath($assetsDir) ?: '';
    }

    public function getResourcesDir(): string
    {
        $r = new \ReflectionClass($this);
        $fileName = pathinfo($r->getFileName() ?: '', \PATHINFO_DIRNAME).'/Resources/';

        return realpath($fileName) ?: '';
    }

    public function normalizeConfig(array $config): array
    {
        $config = [
            'scripts' => $this->getScripts(),
            'styles' => $this->getStyles(),
            'options' => $this->getOptions(),
            ...$config,
        ];

        $config['scripts'] = (array) $config['scripts'];
        $config['styles'] = (array) $config['styles'];

        return $config;
    }
}
