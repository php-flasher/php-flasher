<?php

declare(strict_types=1);

namespace Flasher\Tests\Toastr\Prime;

use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Toastr\Prime\Toastr;
use Flasher\Toastr\Prime\ToastrBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class ToastrTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCanCreateNotificationBuilder(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);

        $toastr = new Toastr($storageManagerMock);
        $result = $toastr->createNotificationBuilder();

        $this->assertInstanceOf(ToastrBuilder::class, $result);
    }

    public function testToastrBuilderTextMethod(): void
    {
        $storageManager = \Mockery::mock(StorageManagerInterface::class);

        $toastr = new Toastr($storageManager);

        $builder = $toastr->createNotificationBuilder();
        $response = $toastr->closeButton(true);

        $this->assertInstanceOf(ToastrBuilder::class, $response);
        $this->assertInstanceOf(ToastrBuilder::class, $builder);
    }
}
