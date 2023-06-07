<?php

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
     * @return string
     */
    public function getConfigurationFile()
    {
        return rtrim($this->getResourcesDir(), '/').'/config.php';
    }

    /**
     * @return void
     */
    protected function registerPublishing()
    {
        if (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'])) {
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

        $paths = [$file => config_path($this->plugin->getName().'.php')];

        $this->publishes($paths);

        $groups = [
            'flasher-config',
            str_replace('_', '-', $this->plugin->getName()).'-config',
        ];

        foreach ($groups as $group) {
            if (!\array_key_exists($group, static::$publishGroups)) {
                static::$publishGroups[$group] = [];
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

        $paths = [$dir => public_path('vendor/flasher/')];

        $this->publishes($paths);

        $groups = [
            'flasher-assets',
            str_replace('_', '-', $this->plugin->getName()).'-assets',
        ];

        foreach ($groups as $group) {
            if (!\array_key_exists($group, static::$publishGroups)) {
                static::$publishGroups[$group] = [];
            }

            static::$publishGroups[$group] = array_merge(static::$publishGroups[$group], $paths);
        }
    }

    /**
     * @return string
     */
    protected function getResourcesDir()
    {
        $r = new \ReflectionClass($this);

        return pathinfo($r->getFileName() ?: '', \PATHINFO_DIRNAME).'/Resources/';
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
        $configuration = $config->get($name, []);

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

        $config = $this->app->make('config')->get($this->plugin->getName(), []); // @phpstan-ignore-line
        $this->app->extend('flasher.resource_manager', function (ResourceManagerInterface $manager) use ($plugin, $config) {
            $config = $plugin->normalizeConfig($config);

            $scripts = isset($config['scripts']) ? $config['scripts'] : [];
            $manager->addScripts($plugin->getAlias(), $scripts);

            $styles = isset($config['styles']) ? $config['styles'] : [];
            $manager->addStyles($plugin->getAlias(), $styles);

            $options = isset($config['options']) ? $config['options'] : [];
            $manager->addOptions($plugin->getAlias(), $options);

            return $manager;
        });
    }
}
