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
