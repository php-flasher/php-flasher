<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime;

use Flasher\Prime\Configuration;
use PHPUnit\Framework\TestCase;

final class ConfigurationTest extends TestCase
{
    public function testFromWithEmptyArray(): void
    {
        $config = ['default' => 'flasher'];

        $result = Configuration::from($config);

        $this->assertSame($config, $result);
    }

    public function testFromWithMinimalConfig(): void
    {
        $config = [
            'default' => 'toastr',
        ];

        $result = Configuration::from($config);

        $this->assertSame($config, $result);
        $this->assertSame('toastr', $result['default']);
    }

    public function testFromWithFullConfig(): void
    {
        $config = [
            'default' => 'flasher',
            'main_script' => '/assets/flasher.min.js',
            'scripts' => ['/assets/plugin1.js', '/assets/plugin2.js'],
            'styles' => ['/assets/flasher.min.css'],
            'inject_assets' => true,
            'translate' => true,
            'excluded_paths' => ['/admin', '/api'],
            'options' => ['timeout' => 5000, 'position' => 'top-right'],
            'filter' => ['limit' => 5],
        ];

        $result = Configuration::from($config);

        $this->assertSame($config, $result);
        $this->assertSame('flasher', $result['default']);
        $this->assertSame('/assets/flasher.min.js', $result['main_script']);
        $this->assertCount(2, $result['scripts']);
        $this->assertCount(1, $result['styles']);
        $this->assertTrue($result['inject_assets']);
        $this->assertTrue($result['translate']);
        $this->assertCount(2, $result['excluded_paths']);
        $this->assertSame(5000, $result['options']['timeout']);
        $this->assertSame(5, $result['filter']['limit']);
    }

    public function testFromWithPluginsConfig(): void
    {
        $config = [
            'default' => 'flasher',
            'plugins' => [
                'toastr' => [
                    'scripts' => ['/assets/toastr.min.js'],
                    'styles' => ['/assets/toastr.min.css'],
                    'options' => ['closeButton' => true],
                ],
                'sweetalert' => [
                    'scripts' => ['/assets/sweetalert.min.js'],
                    'styles' => ['/assets/sweetalert.min.css'],
                    'options' => ['showConfirmButton' => false],
                ],
            ],
        ];

        $result = Configuration::from($config);

        $this->assertSame($config, $result);
        $this->assertArrayHasKey('plugins', $result);
        $this->assertArrayHasKey('toastr', $result['plugins']);
        $this->assertArrayHasKey('sweetalert', $result['plugins']);
        $this->assertSame(['/assets/toastr.min.js'], $result['plugins']['toastr']['scripts']);
        $this->assertTrue($result['plugins']['toastr']['options']['closeButton']);
    }

    public function testFromWithPresetsConfig(): void
    {
        $config = [
            'default' => 'flasher',
            'presets' => [
                'entity_saved' => [
                    'type' => 'success',
                    'title' => 'Saved',
                    'message' => 'Entity has been saved successfully.',
                    'options' => ['timeout' => 3000],
                ],
                'entity_deleted' => [
                    'type' => 'error',
                    'title' => 'Deleted',
                    'message' => 'Entity has been deleted.',
                    'options' => ['timeout' => 5000],
                ],
            ],
        ];

        $result = Configuration::from($config);

        $this->assertSame($config, $result);
        $this->assertArrayHasKey('presets', $result);
        $this->assertArrayHasKey('entity_saved', $result['presets']);
        $this->assertSame('success', $result['presets']['entity_saved']['type']);
        $this->assertSame('Saved', $result['presets']['entity_saved']['title']);
        $this->assertSame('Entity has been saved successfully.', $result['presets']['entity_saved']['message']);
        $this->assertSame(3000, $result['presets']['entity_saved']['options']['timeout']);
    }

    public function testFromWithFlashBagConfig(): void
    {
        $config = [
            'default' => 'flasher',
            'flash_bag' => [
                'success' => ['success', 'ok'],
                'error' => ['error', 'danger', 'fail'],
                'warning' => ['warning', 'warn'],
                'info' => ['info', 'notice'],
            ],
        ];

        $result = Configuration::from($config);

        $this->assertSame($config, $result);
        $this->assertArrayHasKey('flash_bag', $result);
        $this->assertIsArray($result['flash_bag']);
        $this->assertSame(['success', 'ok'], $result['flash_bag']['success']);
        $this->assertSame(['error', 'danger', 'fail'], $result['flash_bag']['error']);
    }

    public function testFromWithFlashBagDisabled(): void
    {
        $config = [
            'default' => 'flasher',
            'flash_bag' => false,
        ];

        $result = Configuration::from($config);

        $this->assertSame($config, $result);
        $this->assertFalse($result['flash_bag']);
    }

    public function testFromWithThemesConfig(): void
    {
        $config = [
            'default' => 'flasher',
            'plugins' => [
                'theme.amazon' => [
                    'scripts' => ['/assets/themes/amazon.js'],
                    'styles' => ['/assets/themes/amazon.css'],
                    'options' => ['position' => 'bottom-right'],
                ],
                'theme.bootstrap' => [
                    'scripts' => ['/assets/themes/bootstrap.js'],
                    'styles' => ['/assets/themes/bootstrap.css'],
                    'options' => ['position' => 'top-center'],
                ],
            ],
        ];

        $result = Configuration::from($config);

        $this->assertSame($config, $result);
        $this->assertArrayHasKey('plugins', $result);
        $this->assertArrayHasKey('theme.amazon', $result['plugins']);
        $this->assertArrayHasKey('theme.bootstrap', $result['plugins']);
    }

    public function testFromPreservesConfigValues(): void
    {
        $originalConfig = [
            'default' => 'noty',
            'main_script' => '/custom/path/flasher.js',
            'scripts' => ['/custom/script1.js'],
            'styles' => ['/custom/style1.css'],
            'inject_assets' => false,
            'translate' => false,
            'excluded_paths' => ['/api/v1', '/api/v2'],
            'options' => [
                'timeout' => 10000,
                'position' => 'bottom-left',
                'closeButton' => true,
            ],
            'filter' => [
                'limit' => 10,
                'orderBy' => 'priority',
            ],
            'presets' => [
                'my_preset' => [
                    'type' => 'info',
                    'title' => 'Info',
                    'message' => 'This is info',
                    'options' => [],
                ],
            ],
            'plugins' => [
                'noty' => [
                    'scripts' => ['/noty.js'],
                    'styles' => ['/noty.css'],
                    'options' => ['layout' => 'topRight'],
                ],
            ],
        ];

        $result = Configuration::from($originalConfig);

        // Verify exact pass-through behavior
        $this->assertSame($originalConfig, $result);

        // Verify no mutation occurred
        $this->assertSame('noty', $result['default']);
        $this->assertFalse($result['inject_assets']);
        $this->assertFalse($result['translate']);
        $this->assertSame(10000, $result['options']['timeout']);
        $this->assertSame('topRight', $result['plugins']['noty']['options']['layout']);
    }

    public function testFromReturnsArrayByReference(): void
    {
        $config = ['default' => 'flasher'];

        $result1 = Configuration::from($config);
        $result2 = Configuration::from($config);

        // Both should be equal
        $this->assertSame($result1, $result2);
    }
}
