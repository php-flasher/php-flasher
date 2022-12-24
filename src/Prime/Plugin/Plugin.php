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
        return realpath(rtrim($this->getResourcesDir(), '/').'/assets/') ?: '';
    }

    /**
     * @return string
     */
    public function getResourcesDir()
    {
        $r = new \ReflectionClass($this);

        return realpath(pathinfo($r->getFileName() ?: '', PATHINFO_DIRNAME).'/Resources/') ?: '';
    }

    /**
     * {@inheritdoc}
     */
    public function processConfiguration(array $options = array())
    {
        return array_merge(array(
            'scripts' => $this->getScripts(),
            'styles' => $this->getStyles(),
            'options' => $this->getOptions(),
        ), $options);
    }
}
