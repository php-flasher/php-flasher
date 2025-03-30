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
}
