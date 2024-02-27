<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony;

use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Symfony\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): ConfigurationInterface
    {
        return new Configuration(
            new FlasherPlugin(),
        );
    }

    public function testValideConfiguration(): void
    {
        $this->assertConfigurationIsValid([[
            'default' => 'flasher',
            'root_script' => 'assets/flasher.js',
            'translate' => true,
            'inject_assets' => true,
            'filter' => ['limit' => 5],
        ]]);
    }

    public function testProcessedConfiguration(): void
    {
        $this->assertProcessedConfigurationEquals(
            [[
                'root_script' => 'assets/flasher.js',
                'styles' => 'assets/flasher.css',
            ]],
            [
                'default' => 'flasher',
                'root_script' => 'assets/flasher.js',
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
                'translate' => true,
                'inject_assets' => true,
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
                'flash_bag' => [],
            ],
        );
    }

    public function testDefaultIsRequired(): void
    {
        $this->assertConfigurationIsInvalid([[
            'default' => null,
        ]], 'required_value');
    }
}
