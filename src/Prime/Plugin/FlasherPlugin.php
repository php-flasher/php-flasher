<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Plugin;

class FlasherPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'flasher';
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceID()
    {
        return 'flasher';
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return 'flasher';
    }

    /**
     * @return string
     */
    public function getRootScript()
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.0.7/dist/flasher.min.js';
    }

    /**
     * @return array<string, string[]>
     */
    public function getFlashBagMapping()
    {
        return array(
            'success' => array('success'),
            'error' => array('error', 'danger'),
            'warning' => array('warning', 'alarm'),
            'info' => array('info', 'notice', 'alert'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function processConfiguration(array $options = array())
    {
        if (\array_key_exists('flash_bag', $options)) {
            $options['flash_bag'] = $this->normalizeFlashBagConfig($options['flash_bag']);
        }

        return array_merge(array(
            'default' => $this->getDefault(),
            'root_script' => $this->getRootScript(),
            'flash_bag' => array(
                'enabled' => true,
                'mapping' => $this->getFlashBagMapping(),
            ),
        ), $options);
    }

    /**
     * @param mixed $config
     *
     * @return array<string, mixed>
     */
    public function normalizeFlashBagConfig($config)
    {
        if (null === $config || false === $config) {
            return array('enabled' => false);
        }

        if (!\is_array($config) || !\array_key_exists('mapping', $config) || !\is_array($config['mapping'])) {
            return array('enabled' => true);
        }

        $mapping = $config['mapping'];

        foreach ($mapping as $key => $values) {
            if (!\is_string($key)) {
                continue;
            }

            if (!\is_array($values)) {
                $mapping[$key] = array($values);
            }

            foreach ($mapping[$key] as $index => $value) {
                if (!\is_string($value)) {
                    unset($mapping[$key][$index]);
                }
            }

            $mapping[$key] = array_values($mapping[$key]);
        }

        return array(
            'enabled' => true,
            'mapping' => $mapping,
        );
    }
}
