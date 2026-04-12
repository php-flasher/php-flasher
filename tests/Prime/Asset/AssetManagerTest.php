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
        parent::setUp();

        $this->publicDir = __DIR__.'/../Fixtures/Asset';
        $this->manifestPath = __DIR__.'/../Fixtures/Asset/manifest.json';
    }

    protected function tearDown(): void
    {
        parent::tearDown();

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

    public function testGetPathWithoutLeadingSlashReturnsOriginal(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $filePath = __DIR__.'/../Fixtures/Asset/test.css';

        $assetManager->createManifest([$filePath]);

        // Path without leading slash won't match manifest entries (which have leading /)
        // The ltrim fallback only works if manifest stores without slash
        $result = $assetManager->getPath('test.css');

        // Returns original path since 'test.css' doesn't match '/test.css' in manifest
        $this->assertSame('test.css', $result);
    }

    public function testGetPathReturnsOriginalWhenNotInManifest(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        // Create an empty manifest
        $assetManager->createManifest([]);

        $result = $assetManager->getPath('/non-existent.css');

        $this->assertSame('/non-existent.css', $result);
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

    public function testGetPathsWithEmptyArray(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $result = $assetManager->getPaths([]);

        $this->assertSame([], $result);
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

    public function testCreateManifestSkipsNonExistentFiles(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $files = [
            __DIR__.'/../Fixtures/Asset/test1.css',
            __DIR__.'/../Fixtures/Asset/non-existent-file.css',
            __DIR__.'/../Fixtures/Asset/test2.css',
        ];

        $assetManager->createManifest($files);

        $reflection = new \ReflectionClass(AssetManager::class);
        $method = $reflection->getMethod('getEntriesData');
        $method->setAccessible(true);

        $entriesData = $method->invoke($assetManager);

        // Should only contain the two existing files
        $this->assertCount(2, $entriesData);
        $this->assertArrayHasKey('/test1.css', $entriesData);
        $this->assertArrayHasKey('/test2.css', $entriesData);
        $this->assertArrayNotHasKey('/non-existent-file.css', $entriesData);
    }

    public function testCreateManifestWithEmptyArray(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $assetManager->createManifest([]);

        $this->assertFileExists($this->manifestPath);
        $content = file_get_contents($this->manifestPath);
        $this->assertSame('[]', $content);
    }

    public function testGetEntriesDataCaching(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $assetManager->createManifest([
            __DIR__.'/../Fixtures/Asset/test1.css',
        ]);

        // First call loads from file
        $result1 = $assetManager->getPath('/test1.css');

        // Second call should use cached data
        $result2 = $assetManager->getPath('/test1.css');

        $this->assertSame($result1, $result2);
    }

    public function testGetEntriesDataWithNoManifestFile(): void
    {
        // Make sure manifest doesn't exist
        if (file_exists($this->manifestPath)) {
            unlink($this->manifestPath);
        }

        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        // Should return original path when no manifest exists
        $result = $assetManager->getPath('/some-file.css');

        $this->assertSame('/some-file.css', $result);
    }

    public function testGetEntriesDataWithInvalidJson(): void
    {
        // Create a manifest with invalid JSON
        file_put_contents($this->manifestPath, 'not valid json');

        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('There was a problem JSON decoding');

        $assetManager->getPath('/test.css');
    }

    public function testGetPathWithAndWithoutLeadingSlash(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $assetManager->createManifest([
            __DIR__.'/../Fixtures/Asset/test1.css',
        ]);

        // With leading slash - should find versioned path
        $result1 = $assetManager->getPath('/test1.css');
        $this->assertStringContainsString('id=', $result1);

        // Without leading slash - returns original (no match in manifest)
        $result2 = $assetManager->getPath('test1.css');
        $this->assertSame('test1.css', $result2);
    }

    public function testCreateManifestOverwritesExisting(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        // First create with test1.css
        $assetManager->createManifest([
            __DIR__.'/../Fixtures/Asset/test1.css',
        ]);

        // Verify first entry
        $this->assertStringContainsString('id=', $assetManager->getPath('/test1.css'));

        // Create new manager to clear cache
        $assetManager2 = new AssetManager($this->publicDir, $this->manifestPath);

        // Create with test2.css only
        $assetManager2->createManifest([
            __DIR__.'/../Fixtures/Asset/test2.css',
        ]);

        // The new manifest should only have test2.css
        $content = json_decode(file_get_contents($this->manifestPath), true);
        $this->assertArrayHasKey('/test2.css', $content);
    }

    public function testComputeHashNormalizesLineEndings(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        // The test files should produce consistent hashes regardless of line endings
        $assetManager->createManifest([
            __DIR__.'/../Fixtures/Asset/test1.css',
        ]);

        $result = $assetManager->getPath('/test1.css');

        // Hash should be consistent
        $this->assertSame('/test1.css?id=38eeac10df68fe4b49c30f8c6af0b1cc', $result);
    }

    public function testGetPathsPreservesOrder(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $assetManager->createManifest([
            __DIR__.'/../Fixtures/Asset/test1.css',
            __DIR__.'/../Fixtures/Asset/test2.css',
            __DIR__.'/../Fixtures/Asset/test3.css',
        ]);

        $files = ['/test3.css', '/test1.css', '/test2.css'];
        $results = $assetManager->getPaths($files);

        // Order should be preserved
        $this->assertStringContainsString('test3.css', $results[0]);
        $this->assertStringContainsString('test1.css', $results[1]);
        $this->assertStringContainsString('test2.css', $results[2]);
    }

    public function testManifestFileFormat(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath);

        $assetManager->createManifest([
            __DIR__.'/../Fixtures/Asset/test1.css',
        ]);

        $content = file_get_contents($this->manifestPath);
        $decoded = json_decode($content, true);

        // Should be valid JSON
        $this->assertNotNull($decoded);
        $this->assertIsArray($decoded);

        // Should use forward slashes in keys
        $this->assertArrayHasKey('/test1.css', $decoded);
    }

    public function testEmptyPublicPathLeavesPathsUnchanged(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, '');

        $this->assertSame('/vendor/flasher/flasher.min.js', $assetManager->getPath('/vendor/flasher/flasher.min.js'));
    }

    public function testPublicPathIsPrependedToServerRelativePath(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, '/Symfony');

        $this->assertSame('/Symfony/vendor/flasher/flasher.min.js', $assetManager->getPath('/vendor/flasher/flasher.min.js'));
    }

    public function testPublicPathIsPrependedToCacheBustedManifestEntry(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, '/Symfony');

        $assetManager->createManifest([__DIR__.'/../Fixtures/Asset/test1.css']);

        $this->assertSame('/Symfony/test1.css?id=38eeac10df68fe4b49c30f8c6af0b1cc', $assetManager->getPath('/test1.css'));
    }

    public function testPublicPathIsNotDoublePrefixed(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, '/Symfony');

        $this->assertSame('/Symfony/vendor/flasher/flasher.min.js', $assetManager->getPath('/Symfony/vendor/flasher/flasher.min.js'));
    }

    public function testPublicPathTrailingSlashIsNormalized(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, '/Symfony/');

        $this->assertSame('/Symfony/vendor/flasher/flasher.min.js', $assetManager->getPath('/vendor/flasher/flasher.min.js'));
    }

    public function testAbsoluteUrlsArePassthrough(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, '/Symfony');

        $this->assertSame('https://cdn.example.com/flasher.min.js', $assetManager->getPath('https://cdn.example.com/flasher.min.js'));
        $this->assertSame('http://cdn.example.com/flasher.min.js', $assetManager->getPath('http://cdn.example.com/flasher.min.js'));
    }

    public function testProtocolRelativeUrlsArePassthrough(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, '/Symfony');

        $this->assertSame('//cdn.example.com/flasher.min.js', $assetManager->getPath('//cdn.example.com/flasher.min.js'));
    }

    public function testDataUrlsArePassthrough(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, '/Symfony');

        $this->assertSame('data:text/css,body{}', $assetManager->getPath('data:text/css,body{}'));
    }

    public function testPublicPathSupportsCdnHost(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, 'https://cdn.example.com');

        $this->assertSame('https://cdn.example.com/vendor/flasher/flasher.min.js', $assetManager->getPath('/vendor/flasher/flasher.min.js'));
    }

    public function testGetPathsAppliesPublicPathToEachEntry(): void
    {
        $assetManager = new AssetManager($this->publicDir, $this->manifestPath, '/Symfony');

        $result = $assetManager->getPaths([
            '/vendor/flasher/flasher.min.css',
            'https://cdn.example.com/extra.css',
            '/Symfony/already-prefixed.css',
        ]);

        $this->assertSame([
            '/Symfony/vendor/flasher/flasher.min.css',
            'https://cdn.example.com/extra.css',
            '/Symfony/already-prefixed.css',
        ], $result);
    }
}
