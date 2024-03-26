<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Asset;

use Flasher\Prime\Asset\AssetManager;
use PHPUnit\Framework\TestCase;

final class AssetManagerTest extends TestCase
{
    private string $publicDir;
    private string $manifestPath;

    protected function setUp(): void
    {
        $this->publicDir = __DIR__.'/../Fixtures/Asset';
        $this->manifestPath = __DIR__.'/../Fixtures/Asset/manifest.json';
    }

    protected function tearDown(): void
    {
        if (file_exists($this->manifestPath)) {
            unlink($this->manifestPath);
        }
    }

    public function testConstruct(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);
        $this->assertInstanceOf(AssetManager::class, $assetManager);
    }

    public function testGetPath(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $filePath = __DIR__.'/../Fixtures/Asset/test.css';

        $assetManager->createManifest([$filePath]);

        $expectedPath = '/test.css?id=2cb85c44817ffbc50452dab7fc3e4823';

        $this->assertSame($expectedPath, $assetManager->getPath('/test.css'));
    }

    public function testGetPaths(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $assetManager->createManifest([
            __DIR__.'/../Fixtures/Asset/test1.css',
            __DIR__.'/../Fixtures/Asset/test2.css',
            __DIR__.'/../Fixtures/Asset/test3.css',
        ]);

        $files = ['/test1.css', '/test2.css', '/test3.css'];
        $expectedPaths = [
            '/test1.css?id=38eeac10df68fe4b49c30f8c6af0b1cc',
            '/test2.css?id=3cb80f170ff572502dca33a5ddb3ead3',
            '/test3.css?id=e7172b646b854195291ebc5b12c88022',
        ];

        $this->assertSame($expectedPaths, $assetManager->getPaths($files));
    }

    public function testCreateManifest(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);
        $files = [
            __DIR__.'/../Fixtures/Asset/test1.css',
            __DIR__.'/../Fixtures/Asset/test2.css',
            __DIR__.'/../Fixtures/Asset/test3.css',
        ];
        $assetManager->createManifest($files);

        $expectedEntries = [
            '/test1.css' => '/test1.css?id=38eeac10df68fe4b49c30f8c6af0b1cc',
            '/test2.css' => '/test2.css?id=3cb80f170ff572502dca33a5ddb3ead3',
            '/test3.css' => '/test3.css?id=e7172b646b854195291ebc5b12c88022',
        ];

        // Using reflection to make getEntriesData() accessible
        $reflection = new \ReflectionClass(AssetManager::class);
        $method = $reflection->getMethod('getEntriesData');
        $method->setAccessible(true);

        $entriesData = $method->invoke($assetManager);

        $this->assertSame($expectedEntries, $entriesData);
    }
}
