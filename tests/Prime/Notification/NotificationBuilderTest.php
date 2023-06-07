<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Notification;

use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Tests\Prime\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

final class NotificationBuilderTest extends TestCase
{
    public function testAddSuccessMessage(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addSuccess('success message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::SUCCESS, $envelope->getType());
        $this->assertEquals('success message', $envelope->getMessage());
    }

    public function testAddErrorMessage(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addError('error message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::ERROR, $envelope->getType());
        $this->assertEquals('error message', $envelope->getMessage());
    }

    public function testAddWarningMessage(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addWarning('warning message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::WARNING, $envelope->getType());
        $this->assertEquals('warning message', $envelope->getMessage());
    }

    public function testAddInfoMessage(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addInfo('info message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::INFO, $envelope->getType());
        $this->assertEquals('info message', $envelope->getMessage());
    }

    public function testAddFlashMessage(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addFlash('success', 'success message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::SUCCESS, $envelope->getType());
        $this->assertEquals('success message', $envelope->getMessage());
    }

    public function testPushToStorage(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->push();
    }

    public function testNotificationType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('success');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::SUCCESS, $envelope->getType());
    }

    public function testNotificationMessage(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->message('some message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals('some message', $envelope->getMessage());
    }

    public function testNotificationTitle(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->title('some title');

        $envelope = $builder->getEnvelope();

        $this->assertEquals('some title', $envelope->getTitle());
    }

    public function testNotificationOptions(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->options(['timeout' => 2000]);

        $envelope = $builder->getEnvelope();

        $this->assertEquals(['timeout' => 2000], $envelope->getOptions());
    }

    public function testNotificationOption(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->option('timeout', 2000);

        $envelope = $builder->getEnvelope();

        $this->assertEquals(2000, $envelope->getOption('timeout'));
    }

    public function testSuccessType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->success();

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::SUCCESS, $envelope->getType());
    }

    public function testErrorType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->error();

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::ERROR, $envelope->getType());
    }

    public function testInfoType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->info();

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::INFO, $envelope->getType());
    }

    public function testWarningType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->warning();

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::WARNING, $envelope->getType());
    }

    public function testWhenCondition(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->when(true);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\WhenStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\WhenStamp::class, $stamp);
        $this->assertTrue($stamp->getCondition());
    }

    public function testUnlessCondition(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->unless(true);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\UnlessStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\UnlessStamp::class, $stamp);
        $this->assertTrue($stamp->getCondition());
    }

    public function testPriority(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->priority(2);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PriorityStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PriorityStamp::class, $stamp);
        $this->assertEquals(2, $stamp->getPriority());
    }

    public function testHops(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->hops(3);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\HopsStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\HopsStamp::class, $stamp);
        $this->assertEquals(3, $stamp->getAmount());
    }

    public function testKeep(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->keep();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\HopsStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\HopsStamp::class, $stamp);
        $this->assertEquals(2, $stamp->getAmount());
    }

    public function testDelay(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->delay(3);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\DelayStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\DelayStamp::class, $stamp);
        $this->assertEquals(3, $stamp->getDelay());
    }

    public function testNow(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->now();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\DelayStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\DelayStamp::class, $stamp);
        $this->assertEquals(0, $stamp->getDelay());
    }

    public function testTranslate(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->translate(['foo' => 'bar'], 'ar');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\TranslationStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\TranslationStamp::class, $stamp);
        $this->assertEquals('ar', $stamp->getLocale());
        $this->assertEquals(['foo' => 'bar'], $stamp->getParameters());
    }

    public function testAddPreset(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addPreset('entity_saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('entity_saved', $stamp->getPreset());
        $this->assertEquals([], $stamp->getParameters());
    }

    public function testAddOperation(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addPreset('saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('saved', $stamp->getPreset());
        $this->assertEquals([], $stamp->getParameters());
    }

    public function testAddCreated(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addCreated();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('created', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testAddUpdated(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addUpdated();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('updated', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testAddSaved(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addSaved();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('saved', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testAddDeleted(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addDeleted();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('deleted', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testPreset(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->preset('entity_saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('entity_saved', $stamp->getPreset());
        $this->assertEquals([], $stamp->getParameters());
    }

    public function testOperation(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->operation('someOperation');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('someOperation', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testCreated(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->created();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('created', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testUpdated(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->updated();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('updated', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testSaved(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->saved();

        $stamp = $builder->getEnvelope()->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('saved', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testDeleted(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->deleted();

        $stamp = $builder->getEnvelope()->get(\Flasher\Prime\Stamp\PresetStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresetStamp::class, $stamp);
        $this->assertEquals('deleted', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testWithStamps(): void
    {
        $builder = $this->getNotificationBuilder();

        $stamps = [
            new PriorityStamp(1),
            new HopsStamp(0),
        ];
        $builder->with($stamps);

        $envelope = $builder->getEnvelope();
        $all = $envelope->all();

        $this->assertEquals($stamps, array_values($all));
    }

    public function testWithStamp(): void
    {
        $builder = $this->getNotificationBuilder();

        $stamp = $this->getMockBuilder(\Flasher\Prime\Stamp\StampInterface::class)->getMock();
        $builder->withStamp($stamp);

        $envelope = $builder->getEnvelope();
        $stamps = $envelope->all();

        $this->assertContains($stamp, $stamps);
    }

    public function testHandler(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->handler('flasher');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\HandlerStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\HandlerStamp::class, $stamp);
        $this->assertEquals('flasher', $stamp->getHandler());
    }

    public function testContext(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->context(['foo' => 'bar']);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(\Flasher\Prime\Stamp\ContextStamp::class);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\ContextStamp::class, $stamp);
        $this->assertEquals(['foo' => 'bar'], $stamp->getContext());
    }

    public function testMacro(): void
    {
        if (PHP_VERSION_ID < 50400) {
            $this->markTestSkipped('Not working for PHP 5.3');
        }

        NotificationBuilder::macro('foo', static fn (): string => 'Called from a macro');

        $builder = $this->getNotificationBuilder();
        $response = $builder->foo();

        $this->assertTrue(NotificationBuilder::hasMacro('foo'));
        $this->assertEquals('Called from a macro', $response);
    }

    /**
     * @phpstan-param MockObject|StorageManagerInterface $storageManager
     *
     * @return NotificationBuilderInterface
     */
    private function getNotificationBuilder(StorageManagerInterface $storageManager = null): NotificationBuilder
    {
        /** @var StorageManagerInterface $storageManager */
        $storageManager = $storageManager ?: $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();

        return new NotificationBuilder($storageManager, new Notification());
    }
}
