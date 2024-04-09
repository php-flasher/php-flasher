<?php

declare(strict_types=1);

namespace Flasher\Tests\Noty\Prime;

use Flasher\Noty\Prime\NotyBuilder;
use Flasher\Prime\Storage\StorageManagerInterface;
use PHPUnit\Framework\TestCase;

final class NotyBuilderTest extends TestCase
{
    private NotyBuilder $notyBuilder;

    protected function setUp(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);
        $this->notyBuilder = new NotyBuilder('noty', $storageManagerMock);
    }

    public function testText(): void
    {
        $this->notyBuilder->text('Test message');

        $envelope = $this->notyBuilder->getEnvelope();
        $notification = $envelope->getNotification();
        $actualMessage = $notification->getMessage();

        $this->assertSame('Test message', $actualMessage);
    }

    public function testAlert(): void
    {
        $this->notyBuilder->alert('Test alert');

        $envelope = $this->notyBuilder->getEnvelope();
        $notification = $envelope->getNotification();

        $this->assertSame('alert', $notification->getType());
    }

    public function testLayout(): void
    {
        $this->notyBuilder->layout('top');

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['layout' => 'top'], $options);
    }

    public function testTheme(): void
    {
        $this->notyBuilder->theme('mint');

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['theme' => 'mint'], $options);
    }

    public function testTimeout(): void
    {
        $this->notyBuilder->timeout(5000);

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['timeout' => 5000], $options);
    }

    public function testProgressBar(): void
    {
        $this->notyBuilder->progressBar(true);

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['progressBar' => true], $options);
    }

    public function testCloseWith(): void
    {
        $closeWith = 'click';
        $this->notyBuilder->closeWith($closeWith);

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeWith' => ['click']], $options);
    }

    public function testAnimation(): void
    {
        $this->notyBuilder->animation('open', 'fadeIn');

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['animation.open' => 'fadeIn'], $options);
    }

    public function testSounds(): void
    {
        $this->notyBuilder->sounds('open', 'sound.mp3');

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['sounds.open' => 'sound.mp3'], $options);
    }

    public function testDocTitle(): void
    {
        $this->notyBuilder->docTitle('Success', 'Title Changed');

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['docTitleSuccess' => 'Title Changed'], $options);
    }

    public function testModal(): void
    {
        $this->notyBuilder->modal(true);

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['modal' => true], $options);
    }

    public function testId(): void
    {
        $this->notyBuilder->id('custom_id');

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['id' => 'custom_id'], $options);
    }

    public function testForce(): void
    {
        $this->notyBuilder->force(true);

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['force' => true], $options);
    }

    public function testQueue(): void
    {
        $this->notyBuilder->queue('customQueue');

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['queue' => 'customQueue'], $options);
    }

    public function testKiller(): void
    {
        $this->notyBuilder->killer(true);

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['killer' => true], $options);
    }

    public function testContainer(): void
    {
        $this->notyBuilder->container('.custom-container');

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['container' => '.custom-container'], $options);
    }

    public function testButtons(): void
    {
        $this->notyBuilder->buttons(['Yes', 'No']);

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['buttons' => ['Yes', 'No']], $options);
    }

    public function testVisibilityControl(): void
    {
        $this->notyBuilder->visibilityControl(true);

        $envelope = $this->notyBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['visibilityControl' => true], $options);
    }
}
