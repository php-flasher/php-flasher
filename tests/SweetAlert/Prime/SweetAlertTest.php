<?php

declare(strict_types=1);

namespace Flasher\Tests\SweetAlert\Prime;

use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\SweetAlert\Prime\SweetAlert;
use Flasher\SweetAlert\Prime\SweetAlertBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class SweetAlertTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCanCreateNotificationBuilder(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);

        $sweetAlert = new SweetAlert($storageManagerMock);
        $result = $sweetAlert->createNotificationBuilder();

        $this->assertInstanceOf(SweetAlertBuilder::class, $result);
    }

    public function testSweetAlertBuilderTextMethod(): void
    {
        $storageManager = \Mockery::mock(StorageManagerInterface::class);

        $sweetAlert = new SweetAlert($storageManager);

        $builder = $sweetAlert->createNotificationBuilder();
        $response = $sweetAlert->target('#my-target');

        $this->assertInstanceOf(SweetAlertBuilder::class, $response);
        $this->assertInstanceOf(SweetAlertBuilder::class, $builder);
    }
}
