<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\DependencyInjection;

use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Symfony\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

final class ConfigurationTest extends TestCase
{
    public function testValidConfiguration(): void
    {
        $configs = [
            'flasher' => [
                'default' => 'flasher',
                'main_script' => 'assets/flasher.js',
                'translate' => true,
                'inject_assets' => true,
                'filter' => ['limit' => 5],
            ],
        ];

        $processedConfig = $this->processConfiguration($configs);

        $this->assertSame('flasher', $processedConfig['default']);
        $this->assertSame('assets/flasher.js', $processedConfig['main_script']);
        $this->assertTrue($processedConfig['translate']);
        $this->assertTrue($processedConfig['inject_assets']);
        $this->assertSame(['limit' => 5], $processedConfig['filter']);
    }

    public function testConfigurationWithDefaults(): void
    {
        $configs = [
            'flasher' => [],
        ];

        $processedConfig = $this->processConfiguration($configs);

        $this->assertSame('flasher', $processedConfig['default']);
        $this->assertSame('/vendor/flasher/flasher.min.js', $processedConfig['main_script']);
        $this->assertTrue($processedConfig['translate']);
        $this->assertTrue($processedConfig['inject_assets']);
    }

    public function testInvalidConfiguration(): void
    {
        $this->expectException(\Exception::class);

        $configs = [
            'flasher' => [
                'default' => null,
            ],
        ];

        $this->processConfiguration($configs);
    }

    public function testMergedConfiguration(): void
    {
        $configs = [
            'flasher' => [
                'main_script' => 'assets/flasher.js',
                'styles' => ['assets/flasher.css'],
            ],
        ];

        $expectedConfig = [
            'default' => 'flasher',
            'main_script' => 'assets/flasher.js',
            'scripts' => [],
            'styles' => ['assets/flasher.css'],
            'options' => [],
            'plugins' => [
                'flasher' => [
                    'styles' => ['assets/flasher.css'],
                    'scripts' => [],
                    'options' => [],
                ],
            ],
            'themes' => [
                'amazon' => [
                    'scripts' => ['/vendor/flasher/themes/amazon/amazon.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/amazon/amazon.min.css',
                    ],
                    'options' => [],
                ],
                'amber' => [
                    'scripts' => ['/vendor/flasher/themes/amber/amber.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/amber/amber.min.css',
                    ],
                    'options' => [],
                ],
                'jade' => [
                    'scripts' => ['/vendor/flasher/themes/jade/jade.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/jade/jade.min.css',
                    ],
                    'options' => [],
                ],
                'crystal' => [
                    'scripts' => ['/vendor/flasher/themes/crystal/crystal.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/crystal/crystal.min.css',
                    ],
                    'options' => [],
                ],
                'emerald' => [
                    'scripts' => ['/vendor/flasher/themes/emerald/emerald.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/emerald/emerald.min.css',
                    ],
                    'options' => [],
                ],
                'sapphire' => [
                    'scripts' => ['/vendor/flasher/themes/sapphire/sapphire.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/sapphire/sapphire.min.css',
                    ],
                    'options' => [],
                ],
                'ruby' => [
                    'scripts' => ['/vendor/flasher/themes/ruby/ruby.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/ruby/ruby.min.css',
                    ],
                    'options' => [],
                ],
                'onyx' => [
                    'scripts' => ['/vendor/flasher/themes/onyx/onyx.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/onyx/onyx.min.css',
                    ],
                    'options' => [],
                ],
                'neon' => [
                    'scripts' => ['/vendor/flasher/themes/neon/neon.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/neon/neon.min.css',
                    ],
                    'options' => [],
                ],
                'aurora' => [
                    'scripts' => ['/vendor/flasher/themes/aurora/aurora.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/aurora/aurora.min.css',
                    ],
                    'options' => [],
                ],
                'minimal' => [
                    'scripts' => ['/vendor/flasher/themes/minimal/minimal.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/minimal/minimal.min.css',
                    ],
                    'options' => [],
                ],
                'material' => [
                    'scripts' => ['/vendor/flasher/themes/material/material.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/material/material.min.css',
                    ],
                    'options' => [],
                ],
                'google' => [
                    'scripts' => ['/vendor/flasher/themes/google/google.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/google/google.min.css',
                    ],
                    'options' => [],
                ],
                'ios' => [
                    'scripts' => ['/vendor/flasher/themes/ios/ios.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/ios/ios.min.css',
                    ],
                    'options' => [],
                ],
                'slack' => [
                    'scripts' => ['/vendor/flasher/themes/slack/slack.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/slack/slack.min.css',
                    ],
                    'options' => [],
                ],
                'facebook' => [
                    'scripts' => ['/vendor/flasher/themes/facebook/facebook.min.js'],
                    'styles' => [
                        '/vendor/flasher/flasher.min.css',
                        '/vendor/flasher/themes/facebook/facebook.min.css',
                    ],
                    'options' => [],
                ],
            ],
            'translate' => true,
            'inject_assets' => true,
            'excluded_paths' => [
                '/^\/_profiler/',
                '/^\/_fragment/',
            ],
            'filter' => [],
            'presets' => [
                'created' => [
                    'type' => 'success',
                    'message' => 'The resource was created',
                    'options' => [],
                ],
                'updated' => [
                    'type' => 'success',
                    'message' => 'The resource was updated',
                    'options' => [],
                ],
                'saved' => [
                    'type' => 'success',
                    'message' => 'The resource was saved',
                    'options' => [],
                ],
                'deleted' => [
                    'type' => 'success',
                    'message' => 'The resource was deleted',
                    'options' => [],
                ],
            ],
            'flash_bag' => [
                'success' => ['success'],
                'error' => ['error', 'danger'],
                'warning' => ['warning', 'alarm'],
                'info' => ['info', 'notice', 'alert'],
            ],
        ];

        $processedConfig = $this->processConfiguration($configs);

        $this->assertEquals($expectedConfig, $processedConfig);
    }

    /**
     * @param array<string, mixed> $configs
     *
     * @return array<string, mixed>
     */
    private function processConfiguration(array $configs): array
    {
        $processor = new Processor();
        $configuration = new Configuration(new FlasherPlugin());

        return $processor->processConfiguration($configuration, $configs);
    }
}
