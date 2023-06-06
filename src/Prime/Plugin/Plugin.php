<?php

namespace Flasher\Prime\Plugin;

abstract class Plugin implements PluginInterface
{
    public function getAlias()
    {
        $alias = basename(str_replace('\\', '/', static::class));
        $alias = str_replace('Plugin', '', $alias);
        /** @var string $alias */
        $alias = preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $alias);

        return strtolower($alias);
    }

    public function getName()
    {
        return 'flasher_'.$this->getAlias();
    }

    public function getServiceID()
    {
        return 'flasher.'.$this->getAlias();
    }

    public function getFactory()
    {
        return str_replace('Plugin', 'Factory', static::class); // @phpstan-ignore-line
    }

    public function getScripts()
    {
        return [];
    }

    public function getStyles()
    {
        return [];
    }

    public function getOptions()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getAssetsDir()
    {
        $resourcesDir = $this->getResourcesDir();
        $assetsDir = rtrim($resourcesDir, '/').'/assets/';

        return realpath($assetsDir) ?: '';
    }

    /**
     * @return string
     */
    public function getResourcesDir()
    {
        $r = new \ReflectionClass($this);
        $fileName = pathinfo($r->getFileName() ?: '', \PATHINFO_DIRNAME).'/Resources/';

        return realpath($fileName) ?: '';
    }

    /**
     * @param array{
     *     scripts?: string|string[]|array{cdn?: string|string[], local?: string|string[]},
     *     styles?: string|string[]|array{cdn?: string|string[], local?: string|string[]},
     *     options?: array<string, mixed>,
     * } $config
     *
     * @return array{
     *  scripts: array{cdn: string[], local: string[]},
     *  styles: array{cdn: string[], local: string[]},
     *  options: array<string, mixed>,
     * }
     */
    public function normalizeConfig(array $config)
    {
        $config = $this->processConfiguration($config);

        $config['styles'] = $this->normalizeAssets($config['styles']);
        $config['scripts'] = $this->normalizeAssets($config['scripts']);

        return $config;
    }

    /**
     * @param array{
     *     scripts?: string|string[]|array{cdn?: string|string[], local?: string|string[]},
     *     styles?: string|string[]|array{cdn?: string|string[], local?: string|string[]},
     *     options?: array<string, mixed>,
     * } $options
     *
     * @return array{
     *    scripts: string|string[]|array{cdn?: string|string[], local?: string|string[]},
     *    styles: string|string[]|array{cdn?: string|string[], local?: string|string[]},
     *    options: array<string, mixed>,
     * }
     */
    public function processConfiguration(array $options = [])
    {
        return array_merge([
            'scripts' => $this->getScripts(),
            'styles' => $this->getStyles(),
            'options' => $this->getOptions(),
        ], $options);
    }

    /**
     * @param string|array{cdn?: string|string[], local?: string|string[]} $assets
     *
     * @return array{cdn: string[], local: string[]}
     */
    protected function normalizeAssets($assets = [])
    {
        if (\is_string($assets)) {
            $assets = ['cdn' => $assets, 'local' => $assets];
        }

        $assets = array_merge(['cdn' => null, 'local' => null], $assets);

        $assets['cdn'] = (array) $assets['cdn'];
        $assets['local'] = (array) $assets['local'];

        return $assets;
    }
}
