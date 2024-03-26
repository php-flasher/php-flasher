<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Factory\NotificationFactoryLocatorInterface;
use Flasher\Prime\Flasher;
use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;

/**
 * Tests for the Flasher class and its methods.
 * This test ensures correct behavior of factory selection and rendering,
 * as well as dynamic method calls.
 */
final class FlasherTest extends MockeryTestCase
{
    private MockInterface&NotificationFactoryLocatorInterface $factoryLocatorMock;
    private MockInterface&ResponseManagerInterface $responseManagerMock;
    private MockInterface&StorageManagerInterface $storageManagerMock;
    private Flasher $flasher;

    protected function setUp(): void
    {
        $this->factoryLocatorMock = \Mockery::mock(NotificationFactoryLocatorInterface::class);
        $this->responseManagerMock = \Mockery::mock(ResponseManagerInterface::class);
        $this->storageManagerMock = \Mockery::mock(StorageManagerInterface::class);

        $this->flasher = new Flasher('default', $this->factoryLocatorMock, $this->responseManagerMock, $this->storageManagerMock);
    }

    public function testUseWithEmptyFactory(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to resolve empty factory');

        $this->flasher->use(' ');
    }

    public function testUseReturnsFactoryLocatorFactoryWhenAliasFound(): void
    {
        $this->factoryLocatorMock->expects()
            ->has('alias')
            ->andReturns(true);

        $this->factoryLocatorMock->expects()
            ->get('alias')
            ->andReturns(\Mockery::mock(NotificationFactoryInterface::class));

        $result = $this->flasher->use('alias');

        $this->assertInstanceOf(NotificationFactoryInterface::class, $result);
    }

    public function testUseReturnsNewFactoryWhenAliasNotFound(): void
    {
        $this->factoryLocatorMock->expects()
            ->has('alias')
            ->andReturns(false);

        $this->factoryLocatorMock->expects()
            ->get('')
            ->never();

        $result = $this->flasher->use('alias');

        $this->assertInstanceOf(NotificationFactoryInterface::class, $result);
    }

    public function testCreateRunsUse(): void
    {
        $this->factoryLocatorMock->expects()
            ->has('alias')
            ->andReturns(true);

        $this->factoryLocatorMock->expects()
            ->get('alias')
            ->andReturns(\Mockery::mock(NotificationFactoryInterface::class));

        $result = $this->flasher->create('alias');

        $this->assertInstanceOf(NotificationFactoryInterface::class, $result);
    }

    public function testRenderRunsRenderManager(): void
    {
        $this->responseManagerMock->expects()
            ->render('html', [], [])
            ->andReturns('Mocked Render Result');

        $result = $this->flasher->render();

        $this->assertSame('Mocked Render Result', $result);
    }

    public function testCallForwardsToUseMethod(): void
    {
        $this->factoryLocatorMock->expects()
            ->has('default')
            ->andReturns(true);

        $mockedFactory = \Mockery::mock(NotificationFactoryInterface::class);
        $mockedFactory->expects('randomMethod')
            ->with('param')
            ->andReturns('Mocked method call');

        $this->factoryLocatorMock->expects('get')
            ->with('default')
            ->andReturns($mockedFactory);

        $result = $this->flasher->randomMethod('param'); // @phpstan-ignore-line

        $this->assertSame('Mocked method call', $result);
    }
}
