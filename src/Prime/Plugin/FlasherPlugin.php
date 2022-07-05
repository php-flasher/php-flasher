<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Plugin;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Notification\NotificationInterface;

/**
 * @phpstan-import-type ConfigType from ConfigInterface
 */
final class FlasherPlugin extends Plugin
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
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.1.1/dist/flasher.min.js';
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
        $options = $this->normalizeConfig($options); // @phpstan-ignore-line

        return array_merge(array(
            'default' => $this->getDefault(),
            'root_script' => $this->getRootScript(),
            'auto_translate' => true,
            'auto_render' => true,
            'flash_bag' => array(
                'enabled' => true,
                'mapping' => $this->getFlashBagMapping(),
            ),
            'filter_criteria' => array(),
        ), $options);
    }

    /**
     * @param array{
     *    template_factory?: array{default: string, templates: array<string, string>},
     *    auto_create_from_session?: bool,
     *    auto_render?: bool,
     *    types_mapping?: array<string, string>,
     *    observer_events?: array<string, string>,
     *    translate_by_default?: bool,
     *        presets?: array<string, array{
     *        type: string,
     *        title: string,
     *        message: string,
     *        options: array<string, mixed>,
     *    }>,
     * } $config
     *
     * @phpstan-return ConfigType
     */
    public function normalizeConfig(array $config)
    {
        $deprecatedKeys = array();

        if (isset($config['template_factory']['default'])) {
            $deprecatedKeys[] = 'template_factory.default';
            unset($config['template_factory']['default']);
        }

        if (isset($config['template_factory']['templates'])) {
            $deprecatedKeys[] = 'template_factory.templates';
            $config['themes'] = $config['template_factory']['templates'];
            unset($config['template_factory']['templates']);
        }

        if (isset($config['auto_create_from_session'])) {
            $deprecatedKeys[] = 'auto_create_from_session';
            $config['flash_bag']['enabled'] = $config['auto_create_from_session'];
            unset($config['auto_create_from_session']);
        }

        if (isset($config['types_mapping'])) {
            $deprecatedKeys[] = 'types_mapping';
            $config['flash_bag']['mapping'] = $config['types_mapping'];
            unset($config['types_mapping']);
        }

        if (isset($config['observer_events'])) {
            $deprecatedKeys[] = 'observer_events';
            unset($config['observer_events']);
        }

        if (isset($config['translate_by_default'])) {
            $deprecatedKeys[] = 'translate_by_default';
            $config['auto_translate'] = $config['translate_by_default'];
            unset($config['translate_by_default']);
        }

        if (array() !== $deprecatedKeys) {
            @trigger_error(sprintf('Since php-flasher/flasher-laravel v1.0: The following configuration keys are deprecated and will be removed in v2.0: %s. Please use the new configuration structure.', implode(', ', $deprecatedKeys)), \E_USER_DEPRECATED);
        }

        if (\array_key_exists('flash_bag', $config)) {
            $config['flash_bag'] = $this->normalizeFlashBagConfig($config['flash_bag']);
        }

        $config['presets'] = array_merge(array(
            'created' => array(
                'type' => NotificationInterface::SUCCESS,
                'message' => 'The resource was created',
            ),
            'updated' => array(
                'type' => NotificationInterface::SUCCESS,
                'message' => 'The resource was updated',
            ),
            'saved' => array(
                'type' => NotificationInterface::SUCCESS,
                'message' => 'The resource was saved',
            ),
            'deleted' => array(
                'type' => NotificationInterface::SUCCESS,
                'message' => 'The resource was deleted',
            ),
        ), isset($config['presets']) ? $config['presets'] : array());

        return $config; // @phpstan-ignore-line
    }

    /**
     * @param mixed $config
     *
     * @return array<string, mixed>
     */
    private function normalizeFlashBagConfig($config)
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
