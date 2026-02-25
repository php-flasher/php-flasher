<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Plugin;

use Flasher\Prime\Plugin\FlasherPlugin;
use PHPUnit\Framework\TestCase;

final class FlasherPluginTest extends TestCase
{
    public function testGetName(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame('flasher', $plugin->getName());
    }

    public function testGetServiceID(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame('flasher', $plugin->getServiceId());
    }

    public function testGetDefault(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame('flasher', $plugin->getDefault());
    }

    public function testGetRootScript(): void
    {
        $plugin = new FlasherPlugin();
        $rootScript = '/vendor/flasher/flasher.min.js';

        $this->assertSame($rootScript, $plugin->getRootScript());
    }

    public function testGetScripts(): void
    {
        $plugin = new FlasherPlugin();

        $this->assertSame([], $plugin->getScripts());
    }

    public function testProcessConfiguration(): void
    {
        $plugin = new FlasherPlugin();
        $config = [
            'default' => 'flasher',
            'main_script' => '/vendor/flasher/flasher.min.js',
            'scripts' => [],
            'styles' => ['/vendor/flasher/flasher.min.css'],
            'options' => [],
            'translate' => true,
            'inject_assets' => true,
            'flash_bag' => [
                'success' => ['success'],
                'error' => ['error', 'danger'],
                'warning' => ['warning', 'alarm'],
                'info' => ['info', 'notice', 'alert'],
            ],
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
            'plugins' => [
                'flasher' => [
                    'scripts' => [],
                    'styles' => ['/vendor/flasher/flasher.min.css'],
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
            'filter' => [],
        ];

        $this->assertEquals($config, $plugin->normalizeConfig());
    }

    public function testNormalizeConfigWithScriptsStylesOptions(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'scripts' => ['/custom/script.js'],
            'styles' => ['/custom/style.css'],
            'options' => ['timeout' => 5000],
        ]);

        $this->assertContains('/custom/script.js', $config['plugins']['flasher']['scripts']);
        $this->assertContains('/custom/style.css', $config['plugins']['flasher']['styles']);
        $this->assertSame(5000, $config['plugins']['flasher']['options']['timeout']);
    }

    public function testNormalizeConfigWithFlashBagFalse(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'flash_bag' => false,
        ]);

        $this->assertFalse($config['flash_bag']);
    }

    public function testNormalizeConfigWithFlashBagTrue(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'flash_bag' => true,
        ]);

        $this->assertIsArray($config['flash_bag']);
        $this->assertArrayHasKey('success', $config['flash_bag']);
        $this->assertArrayHasKey('error', $config['flash_bag']);
        $this->assertArrayHasKey('warning', $config['flash_bag']);
        $this->assertArrayHasKey('info', $config['flash_bag']);
    }

    public function testNormalizeConfigWithCustomFlashBag(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'flash_bag' => [
                'custom' => ['custom_type'],
            ],
        ]);

        $this->assertIsArray($config['flash_bag']);
        $this->assertArrayHasKey('custom', $config['flash_bag']);
        $this->assertArrayHasKey('success', $config['flash_bag']);
    }

    public function testNormalizeConfigWithPresetsAsStrings(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'presets' => [
                'my_preset' => 'My custom message',
            ],
        ]);

        $this->assertIsArray($config['presets']['my_preset']);
        $this->assertSame('My custom message', $config['presets']['my_preset']['message']);
        $this->assertSame('info', $config['presets']['my_preset']['type']);
    }

    public function testNormalizeConfigWithCustomDefault(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'default' => 'toastr',
            'main_script' => '/custom/main.js',
            'translate' => false,
            'inject_assets' => false,
            'filter' => ['limit' => 5],
        ]);

        $this->assertSame('toastr', $config['default']);
        $this->assertSame('/custom/main.js', $config['main_script']);
        $this->assertFalse($config['translate']);
        $this->assertFalse($config['inject_assets']);
        $this->assertSame(['limit' => 5], $config['filter']);
    }

    public function testNormalizeConfigWithNullValues(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'default' => null,
            'main_script' => null,
        ]);

        $this->assertNull($config['default']);
        $this->assertNull($config['main_script']);
    }

    public function testNormalizeConfigWithCustomTheme(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'themes' => [
                'custom_theme' => [
                    'scripts' => ['/custom/theme.js'],
                    'styles' => ['/custom/theme.css'],
                ],
                'amazon' => [
                    'options' => ['custom' => 'option'],
                ],
            ],
        ]);

        // Custom theme should be added
        $this->assertArrayHasKey('custom_theme', $config['themes']);
        $this->assertSame(['/custom/theme.js'], $config['themes']['custom_theme']['scripts']);

        // Amazon should have custom options but default scripts/styles
        $this->assertArrayHasKey('amazon', $config['themes']);
        $this->assertSame(['custom' => 'option'], $config['themes']['amazon']['options']);
    }

    public function testNormalizeConfigWithPluginsPartialConfig(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'plugins' => [
                'toastr' => [
                    'scripts' => '/single/script.js',
                    'styles' => '/single/style.css',
                ],
            ],
        ]);

        // Scripts/styles should be normalized to arrays
        $this->assertSame(['/single/script.js'], $config['plugins']['toastr']['scripts']);
        $this->assertSame(['/single/style.css'], $config['plugins']['toastr']['styles']);
    }

    public function testNormalizeConfigWithThemesMissingOptions(): void
    {
        $plugin = new FlasherPlugin();
        $config = $plugin->normalizeConfig([
            'themes' => [
                'test_theme' => [
                    'scripts' => '/test/script.js',
                    'styles' => '/test/style.css',
                ],
            ],
        ]);

        $this->assertArrayHasKey('options', $config['themes']['test_theme']);
        $this->assertSame([], $config['themes']['test_theme']['options']);
    }

    public function testGetAlias(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame('flasher', $plugin->getAlias());
    }

    public function testGetServiceAliases(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame(\Flasher\Prime\FlasherInterface::class, $plugin->getServiceAliases());
    }

    public function testGetFactory(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame(\Flasher\Prime\Factory\NotificationFactory::class, $plugin->getFactory());
    }

    public function testGetStyles(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame('/vendor/flasher/flasher.min.css', $plugin->getStyles());
    }

    public function testGetOptions(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame([], $plugin->getOptions());
    }
}
