<?php

declare(strict_types=1);

namespace Flasher\Tests\Notyf\Prime;

use Flasher\Notyf\Prime\NotyfBuilder;
use Flasher\Prime\Storage\StorageManagerInterface;
use PHPUnit\Framework\TestCase;

final class NotyfBuilderTest extends TestCase
{
    private NotyfBuilder $notyfBuilder;

    protected function setUp(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);
        $this->notyfBuilder = new NotyfBuilder('notyf', $storageManagerMock);
    }

    public function testDuration(): void
    {
        $this->notyfBuilder->duration(6000);

        $envelope = $this->notyfBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['duration' => 6000], $options);
    }

    public function testRipple(): void
    {
        $this->notyfBuilder->ripple();

        $envelope = $this->notyfBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['ripple' => true], $options);
    }

    public function testPosition(): void
    {
        $this->notyfBuilder->position('x', 'center');
        $this->notyfBuilder->position('y', 'top');

        $envelope = $this->notyfBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['position' => ['x' => 'center', 'y' => 'top']], $options);
    }

    public function testDismissible(): void
    {
        $this->notyfBuilder->dismissible(true);

        $envelope = $this->notyfBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['dismissible' => true], $options);
    }
}
