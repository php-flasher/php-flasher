<?php

namespace Flasher\Laravel\ServiceProvider;

use Flasher\Prime\Response\Resource\ResourceManager;

final class ResourceManagerHelper
{
    /**
     * @param string $alias
     * @param array<string, mixed> $config
     *
     * @return void
     */
    public static function process(ResourceManager $responseManager, $alias, $config = null)
    {
        if (null === $config) {
            $config = $responseManager->getConfig()->get('adapters.' . $alias);
        }

        $responseManager->addScripts($alias, self::getScripts($config));
        $responseManager->addStyles($alias, self::getStyles($config));
        $responseManager->addOptions($alias, self::getOptions($config));
    }

    /**
     * @param array<string, mixed> $config
     *
     * @return string[]
     */
    private static function getScripts($config)
    {
        return isset($config['scripts']) ? $config['scripts'] : array();
    }

    /**
     * @param array<string, mixed> $config
     *
     * @return string[]
     */
    private static function getStyles($config)
    {
        return isset($config['styles']) ? $config['styles'] : array();
    }

    /**
     * @param array<string, mixed> $config
     *
     * @return array<string, mixed>
     */
    private static function getOptions($config)
    {
        return isset($config['options']) ? $config['options'] : array();
    }
}
