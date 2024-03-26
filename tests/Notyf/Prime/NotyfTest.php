<?php

declare(strict_types=1);

namespace Flasher\Tests\Notyf\Prime;

use Flasher\Notyf\Prime\Notyf;
use Flasher\Notyf\Prime\NotyfBuilder;
use Flasher\Prime\Storage\StorageManagerInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class NotyfTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCanCreateNotificationBuilder(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);

        $notyf = new Notyf($storageManagerMock);
        $result = $notyf->createNotificationBuilder();

        $this->assertInstanceOf(NotyfBuilder::class, $result);
    }

    public function testNotyfBuilderTextMethod(): void
    {
        $storageManager = \Mockery::mock(StorageManagerInterface::class);

        $notyf = new Notyf($storageManager);

        $builder = $notyf->createNotificationBuilder();
        $response = $notyf->duration(6000);

        $this->assertInstanceOf(NotyfBuilder::class, $response);
        $this->assertInstanceOf(NotyfBuilder::class, $builder);
    }
}
