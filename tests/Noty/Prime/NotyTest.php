<?php

declare(strict_types=1);

namespace Flasher\Tests\Noty\Prime;

use Flasher\Noty\Prime\Noty;
use Flasher\Noty\Prime\NotyBuilder;
use Flasher\Prime\Storage\StorageManagerInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class NotyTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCanCreateNotificationBuilder(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);

        $noty = new Noty($storageManagerMock);
        $result = $noty->createNotificationBuilder();

        $this->assertInstanceOf(NotyBuilder::class, $result);
    }

    public function testNotyBuilderTextMethod(): void
    {
        $storageManager = \Mockery::mock(StorageManagerInterface::class);

        $noty = new Noty($storageManager);

        $builder = $noty->createNotificationBuilder();
        $response = $noty->text('Hello World');

        $this->assertInstanceOf(NotyBuilder::class, $response);
        $this->assertInstanceOf(NotyBuilder::class, $builder);
    }
}
