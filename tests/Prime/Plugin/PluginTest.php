<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Plugin;

use Flasher\Prime\Plugin\Plugin;
use PHPUnit\Framework\TestCase;

final class PluginTest extends TestCase
{
    private Plugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new class extends Plugin {
            public function getAlias(): string
            {
                return 'test_plugin';
            }

            public function getFactory(): string
            {
                return 'TestFactory';
            }
        };
    }

    public function testGetName(): void
    {
        $this->assertSame('flasher_test_plugin', $this->plugin->getName());
    }

    public function testGetServiceId(): void
    {
        $this->assertSame('flasher.test_plugin', $this->plugin->getServiceId());
    }

    public function testGetServiceAliases(): void
    {
        $this->assertSame([], $this->plugin->getServiceAliases());
    }

    public function testGetScripts(): void
    {
        $this->assertSame([], $this->plugin->getScripts());
    }

    public function testGetStyles(): void
    {
        $this->assertSame([], $this->plugin->getStyles());
    }

    public function testGetOptions(): void
    {
        $this->assertSame([], $this->plugin->getOptions());
    }

    public function testNormalizeConfig(): void
    {
        $config = $this->plugin->normalizeConfig([
            'timeout' => 5000,
        ]);

        $this->assertArrayHasKey('scripts', $config);
        $this->assertArrayHasKey('styles', $config);
        $this->assertArrayHasKey('options', $config);
        $this->assertSame(5000, $config['timeout']);
        $this->assertSame([], $config['scripts']);
        $this->assertSame([], $config['styles']);
    }

    public function testNormalizeConfigWithScriptsAsString(): void
    {
        $plugin = new class extends Plugin {
            public function getAlias(): string
            {
                return 'string_test';
            }

            public function getFactory(): string
            {
                return 'TestFactory';
            }

            public function getScripts(): string
            {
                return '/path/to/script.js';
            }

            public function getStyles(): string
            {
                return '/path/to/style.css';
            }

            public function getOptions(): array
            {
                return ['timeout' => 3000];
            }
        };

        $config = $plugin->normalizeConfig([]);

        $this->assertSame(['/path/to/script.js'], $config['scripts']);
        $this->assertSame(['/path/to/style.css'], $config['styles']);
        $this->assertSame(['timeout' => 3000], $config['options']);
    }

    public function testNormalizeConfigMergesWithUserConfig(): void
    {
        $plugin = new class extends Plugin {
            public function getAlias(): string
            {
                return 'merge_test';
            }

            public function getFactory(): string
            {
                return 'TestFactory';
            }

            public function getScripts(): array
            {
                return ['/default/script.js'];
            }

            public function getOptions(): array
            {
                return ['timeout' => 3000];
            }
        };

        $config = $plugin->normalizeConfig([
            'scripts' => ['/custom/script.js'],
            'options' => ['custom' => 'option'],
        ]);

        // User config should override defaults via spread operator
        $this->assertSame(['/custom/script.js'], $config['scripts']);
        $this->assertSame(['custom' => 'option'], $config['options']);
    }

    public function testGetAssetsDirReturnsEmptyStringForNonExistentDir(): void
    {
        $this->assertSame('', $this->plugin->getAssetsDir());
    }

    public function testGetResourcesDirReturnsEmptyStringForNonExistentDir(): void
    {
        // The anonymous class doesn't have a valid Resources directory
        $this->assertSame('', $this->plugin->getResourcesDir());
    }

    public function testPluginWithServiceAliasesAsString(): void
    {
        $plugin = new class extends Plugin {
            public function getAlias(): string
            {
                return 'alias_test';
            }

            public function getFactory(): string
            {
                return 'TestFactory';
            }

            public function getServiceAliases(): string
            {
                return 'TestInterface';
            }
        };

        $this->assertSame('TestInterface', $plugin->getServiceAliases());
    }

    public function testPluginWithServiceAliasesAsArray(): void
    {
        $plugin = new class extends Plugin {
            public function getAlias(): string
            {
                return 'alias_array_test';
            }

            public function getFactory(): string
            {
                return 'TestFactory';
            }

            public function getServiceAliases(): array
            {
                return ['TestInterface1', 'TestInterface2'];
            }
        };

        $this->assertSame(['TestInterface1', 'TestInterface2'], $plugin->getServiceAliases());
    }
}
