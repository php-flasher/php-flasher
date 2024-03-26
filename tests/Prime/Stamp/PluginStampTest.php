<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\PluginStamp;
use PHPUnit\Framework\TestCase;

final class PluginStampTest extends TestCase
{
    /**
     * Test that the getPlugin method in the PluginStamp class returns the correct
     * string value that was passed to the class constructor during instantiation.
     */
    public function testGetPluginMethod(): void
    {
        $plugin = 'myPlugin';
        $pluginStamp = new PluginStamp($plugin);

        $result = $pluginStamp->getPlugin();

        $this->assertSame($plugin, $result);
    }

    /**
     * Test that the toArray method in PluginStamp class returns the correct
     * array with 'plugin' key that was passed to the class constructor during instantiation.
     */
    public function testToArrayMethod(): void
    {
        $plugin = 'myPlugin';
        $pluginStamp = new PluginStamp($plugin);

        $result = $pluginStamp->toArray();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertArrayHasKey('plugin', $result);
        $this->assertSame($plugin, $result['plugin']);
    }
}
