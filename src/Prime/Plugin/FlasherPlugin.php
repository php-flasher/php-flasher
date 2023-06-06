<?php

namespace Flasher\Prime\Plugin;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Notification\NotificationInterface;

/**
 * @phpstan-import-type ConfigType from ConfigInterface
 */
final class FlasherPlugin extends Plugin
{
    public function getName()
    {
        return 'flasher';
    }

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
     * @return string|array{cdn: string, local: string}
     */
    public function getRootScript()
    {
        return [
            'cdn' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js',
            'local' => '/vendor/flasher/flasher.min.js',
        ];
    }

    public function getScripts()
    {
        $rootScript = $this->getRootScript();

        return [
            'cdn' => \is_string($rootScript) ? [$rootScript] : [$rootScript['cdn']],
            'local' => \is_string($rootScript) ? '' : [$rootScript['local']],
        ];
    }

    public function getStyles()
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.css',
            ],
            'local' => [
                '/vendor/flasher/flasher.min.css',
            ],
        ];
    }

    /**
     * @return string
     */
    public function getResourcesDir()
    {
        return realpath(__DIR__.'/../Resources') ?: '';
    }

    /**
     * @return array<string, string[]>
     */
    public function getFlashBagMapping()
    {
        return [
            'success' => ['success'],
            'error' => ['error', 'danger'],
            'warning' => ['warning', 'alarm'],
            'info' => ['info', 'notice', 'alert'],
        ];
    }

    public function processConfiguration(array $options = [])
    {
        $options = $this->normalizeConfig($options); // @phpstan-ignore-line

        return array_merge([
            'default' => $this->getDefault(),
            'root_script' => $this->getRootScript(),
            'scripts' => [],
            'styles' => $this->getStyles(),
            'options' => [],
            'use_cdn' => true,
            'auto_translate' => true,
            'auto_render' => true,
            'flash_bag' => [
                'enabled' => true,
                'mapping' => $this->getFlashBagMapping(),
            ],
            'filter_criteria' => [],
        ], $options);
    }

    /**
     * @param array{
     *    root_script?: string|array,
     *    styles?: string|array,
     *    scripts ?: string|array,
     *    template_factory?: array{default: string, templates: array<string, array<string, string>>},
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
        if (isset($config['root_script']) && \is_string($config['root_script'])) {
            $config['root_script'] = [
                'local' => $config['root_script'],
                'cdn' => $config['root_script'],
            ];
        }

        if (isset($config['styles'])) {
            if (\is_string($config['styles'])) {
                $config['styles'] = ['cdn' => $config['styles'], 'local' => $config['styles']];
            }

            $config['styles']['cdn'] = (array) $config['styles']['cdn'];
            $config['styles']['local'] = (array) $config['styles']['local'];
        }

        if (isset($config['scripts'])) {
            if (\is_string($config['scripts'])) {
                $config['scripts'] = ['cdn' => $config['scripts'], 'local' => $config['scripts']];
            }

            $config['scripts']['cdn'] = (array) $config['scripts']['cdn'];
            $config['scripts']['local'] = (array) $config['scripts']['local'];
        }

        $deprecatedKeys = [];

        if (isset($config['template_factory']['default'])) {
            $deprecatedKeys[] = 'template_factory.default';
            unset($config['template_factory']['default']);
        }

        if (isset($config['template_factory']['templates'])) {
            $deprecatedKeys[] = 'template_factory.templates';
            $config['themes'] = $config['template_factory']['templates'];
            unset($config['template_factory']['templates']);
        }

        unset($config['template_factory']);

        if (isset($config['themes']['flasher']['options'])) {
            $deprecatedKeys[] = 'themes.flasher.options';
            $config['options'] = $config['themes']['flasher']['options'];
            unset($config['themes']['flasher']['options']);
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

        if ([] !== $deprecatedKeys) {
            @trigger_error(sprintf('Since php-flasher/flasher-laravel v1.0: The following configuration keys are deprecated and will be removed in v2.0: %s. Please use the new configuration structure.', implode(', ', $deprecatedKeys)), \E_USER_DEPRECATED);
        }

        if (\array_key_exists('flash_bag', $config)) {
            $config['flash_bag'] = $this->normalizeFlashBagConfig($config['flash_bag']);
        }

        $config['presets'] = array_merge([
            'created' => [
                'type' => NotificationInterface::SUCCESS,
                'message' => 'The resource was created',
            ],
            'updated' => [
                'type' => NotificationInterface::SUCCESS,
                'message' => 'The resource was updated',
            ],
            'saved' => [
                'type' => NotificationInterface::SUCCESS,
                'message' => 'The resource was saved',
            ],
            'deleted' => [
                'type' => NotificationInterface::SUCCESS,
                'message' => 'The resource was deleted',
            ],
        ], isset($config['presets']) ? $config['presets'] : []);

        return $config; // @phpstan-ignore-line
    }

    /**
     * @return array<string, mixed>
     */
    private function normalizeFlashBagConfig($config)
    {
        if (null === $config || false === $config) {
            return ['enabled' => false];
        }

        if (!\is_array($config) || !\array_key_exists('mapping', $config) || !\is_array($config['mapping'])) {
            return ['enabled' => true];
        }

        $mapping = $config['mapping'];

        foreach ($mapping as $key => $values) {
            if (!\is_string($key)) {
                continue;
            }

            if (!\is_array($values)) {
                $mapping[$key] = [$values];
            }

            foreach ($mapping[$key] as $index => $value) {
                if (!\is_string($value)) {
                    unset($mapping[$key][$index]);
                }
            }

            $mapping[$key] = array_values($mapping[$key]);
        }

        return [
            'enabled' => true,
            'mapping' => $mapping,
        ];
    }
}
