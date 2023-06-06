<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Plugin;

abstract class Plugin implements PluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        $alias = basename(str_replace('\\', '/', \get_class($this)));
        $alias = str_replace('Plugin', '', $alias);
        /** @var string $alias */
        $alias = preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $alias);

        return strtolower($alias);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'flasher_'.$this->getAlias();
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceID()
    {
        return 'flasher.'.$this->getAlias();
    }

    /**
     * {@inheritdoc}
     */
    public function getFactory()
    {
        return str_replace('Plugin', 'Factory', \get_class($this)); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getStyles()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return array();
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
        $fileName = pathinfo($r->getFileName() ?: '', PATHINFO_DIRNAME).'/Resources/';

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
    public function processConfiguration(array $options = array())
    {
        return array_merge(array(
            'scripts' => $this->getScripts(),
            'styles' => $this->getStyles(),
            'options' => $this->getOptions(),
        ), $options);
    }

    /**
     * @param string|array{cdn?: string|string[], local?: string|string[]} $assets
     *
     * @return array{cdn: string[], local: string[]}
     */
    protected function normalizeAssets($assets = array())
    {
        if (is_string($assets)) {
            $assets = array('cdn' => $assets, 'local' => $assets);
        }

        $assets = array_merge(array('cdn' => null, 'local' => null), $assets);

        $assets['cdn'] = (array) $assets['cdn'];
        $assets['local'] = (array) $assets['local'];

        return $assets;
    }
}
