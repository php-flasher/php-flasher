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
        $this->registerFactory();
        $this->afterBoot();
    }

    /**
     * @return PluginInterface
     */
    abstract protected function createPlugin();

    /**
     * @return void
     */
    protected function processConfiguration()
    {
        if (null === $this->plugin) {
            return;
        }

        $name = $this->plugin->getName();
        $config = $this->app['config']; // @phpstan-ignore-line

        $config->set($name, $this->plugin->processConfiguration(
            $config->get($name, array())
        ));
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

            return new $factory($app['flasher.storage_manager']);
        });

        $this->app->alias($plugin->getServiceID(), $plugin->getFactory());

        $this->app->extend('flasher', function (FlasherInterface $flasher, Container $app) use ($plugin) {
            $flasher->addFactory($plugin->getAlias(), $app[$plugin->getServiceID()]); // @phpstan-ignore-line

            return $flasher;
        });

        $config = $this->app['config']->get($this->plugin->getName(), array()); // @phpstan-ignore-line
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
