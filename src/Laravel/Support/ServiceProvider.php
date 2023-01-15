<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Support;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Prime\Response\Resource\ResourceManagerInterface;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

abstract class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var PluginInterface|null
     */
    protected $plugin;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->plugin = $this->plugin ?: $this->createPlugin();

        $this->processConfiguration();
        $this->afterRegister();
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
        $this->registerFactory();
        $this->afterBoot();
    }

    /**
     * @return PluginInterface
     */
    abstract public function createPlugin();

    /**
     * @return void
     */
    protected function registerPublishing()
    {
        if (!in_array(\PHP_SAPI, array('cli', 'phpdbg'))) {
            return;
        }

        if (Laravel::isVersion('4')) {
            return;
        }

        $this->publishConfiguration();
        $this->publishAssets();
    }

    /**
     * @return void
     */
    protected function publishConfiguration()
    {
        if (null === $this->plugin) {
            return;
        }

        $file = $this->getConfigurationFile();
        if (!file_exists($file)) {
            return;
        }

        $paths = array($file => config_path($this->plugin->getName().'.php'));

        $this->publishes($paths);

        $groups = array(
            'flasher-config',
            str_replace('_', '-', $this->plugin->getName()).'-config',
        );

        foreach ($groups as $group) {
            if (!array_key_exists($group, static::$publishGroups)) {
                static::$publishGroups[$group] = array();
            }

            static::$publishGroups[$group] = array_merge(static::$publishGroups[$group], $paths);
        }
    }

    /**
     * @return void
     */
    protected function publishAssets()
    {
        if (null === $this->plugin) {
            return;
        }

        $dir = $this->plugin->getAssetsDir();

        if (!is_dir($dir)) {
            return;
        }

        $paths = array($dir => public_path('vendor/flasher/'));

        $this->publishes($paths);

        $groups = array(
            'flasher-assets',
            str_replace('_', '-', $this->plugin->getName()).'-assets',
        );

        foreach ($groups as $group) {
            if (!array_key_exists($group, static::$publishGroups)) {
                static::$publishGroups[$group] = array();
            }

            static::$publishGroups[$group] = array_merge(static::$publishGroups[$group], $paths);
        }
    }

    /**
     * @return string
     */
    public function getConfigurationFile()
    {
        return rtrim($this->getResourcesDir(), '/').'/config.php';
    }

    /**
     * @return string
     */
    protected function getResourcesDir()
    {
        $r = new \ReflectionClass($this);

        return pathinfo($r->getFileName() ?: '', PATHINFO_DIRNAME).'/Resources/';
    }

    /**
     * @return void
     */
    protected function processConfiguration()
    {
        if (null === $this->plugin) {
            return;
        }

        /** @var Repository $config */
        $config = $this->app->make('config');

        $name = $this->plugin->getName();

        /** @var array<string, mixed> $configuration */
        $configuration = $config->get($name, array());

        $config->set($name, $this->plugin->processConfiguration($configuration));
    }

    /**
     * @return void
     */
    protected function afterRegister()
    {
    }

    /**
     * @return void
     */
    protected function afterBoot()
    {
    }

    /**
     * @return void
     */
    protected function registerFactory()
    {
        $plugin = $this->plugin;
        if (null === $plugin) {
            return;
        }

        if (!class_exists($plugin->getFactory())) {
            return;
        }

        $this->app->singleton($plugin->getServiceID(), function (Container $app) use ($plugin) {
            $factory = $plugin->getFactory();

            return new $factory($app->make('flasher.storage_manager'));
        });

        $this->app->alias($plugin->getServiceID(), $plugin->getFactory());

        $this->app->extend('flasher', function (FlasherInterface $flasher, Container $app) use ($plugin) {
            $flasher->addFactory($plugin->getAlias(), $app->make($plugin->getServiceID())); // @phpstan-ignore-line

            return $flasher;
        });

        $config = $this->app->make('config')->get($this->plugin->getName(), array()); // @phpstan-ignore-line
        $this->app->extend('flasher.resource_manager', function (ResourceManagerInterface $manager) use ($plugin, $config) {
            $scripts = isset($config['scripts']) ? $config['scripts'] : array();
            $manager->addScripts($plugin->getAlias(), $scripts);

            $styles = isset($config['styles']) ? $config['styles'] : array();
            $manager->addStyles($plugin->getAlias(), $styles);

            $options = isset($config['options']) ? $config['options'] : array();
            $manager->addOptions($plugin->getAlias(), $options);

            return $manager;
        });
    }
}
