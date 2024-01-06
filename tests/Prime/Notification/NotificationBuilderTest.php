<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Notification;

use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Notification\Type;
use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Tests\Prime\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

final class NotificationBuilderTest extends TestCase
{
    public function testAddSuccessMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->success('success message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::SUCCESS, $envelope->getType());
        $this->assertEquals('success message', $envelope->getMessage());
    }

    public function testAddErrorMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->error('error message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::ERROR, $envelope->getType());
        $this->assertEquals('error message', $envelope->getMessage());
    }

    public function testAddWarningMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->warning('warning message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::WARNING, $envelope->getType());
        $this->assertEquals('warning message', $envelope->getMessage());
    }

    public function testAddInfoMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->info('info message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::INFO, $envelope->getType());
        $this->assertEquals('info message', $envelope->getMessage());
    }

    public function testAddFlashMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->flash('success', 'success message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::SUCCESS, $envelope->getType());
        $this->assertEquals('success message', $envelope->getMessage());
    }

    public function testPushToStorage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->push();
    }

    public function testNotificationType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('success');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::SUCCESS, $envelope->getType());
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
        $builder->type('success');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::SUCCESS, $envelope->getType());
    }

    public function testErrorType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('error');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::ERROR, $envelope->getType());
    }

    public function testInfoType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('info');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::INFO, $envelope->getType());
    }

    public function testWarningType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('warning');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(Type::WARNING, $envelope->getType());
    }

    public function testWhenCondition(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->when(true);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(WhenStamp::class);

        $this->assertInstanceOf(WhenStamp::class, $stamp);
        $this->assertTrue($stamp->getCondition());
    }

    public function testUnlessCondition(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->unless(true);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(UnlessStamp::class);

        $this->assertInstanceOf(UnlessStamp::class, $stamp);
        $this->assertTrue($stamp->getCondition());
    }

    public function testPriority(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->priority(2);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PriorityStamp::class);

        $this->assertInstanceOf(PriorityStamp::class, $stamp);
        $this->assertEquals(2, $stamp->getPriority());
    }

    public function testHops(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->hops(3);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(HopsStamp::class);

        $this->assertInstanceOf(HopsStamp::class, $stamp);
        $this->assertEquals(3, $stamp->getAmount());
    }

    public function testKeep(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->keep();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(HopsStamp::class);

        $this->assertInstanceOf(HopsStamp::class, $stamp);
        $this->assertEquals(2, $stamp->getAmount());
    }

    public function testDelay(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->delay(3);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(DelayStamp::class);

        $this->assertInstanceOf(DelayStamp::class, $stamp);
        $this->assertEquals(3, $stamp->getDelay());
    }

    public function testTranslate(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->translate(['foo' => 'bar'], 'ar');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(TranslationStamp::class);

        $this->assertInstanceOf(TranslationStamp::class, $stamp);
        $this->assertEquals('ar', $stamp->getLocale());
        $this->assertEquals(['foo' => 'bar'], $stamp->getParameters());
    }

    public function testAddPreset(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->preset('entity_saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('entity_saved', $stamp->getPreset());
        $this->assertEquals([], $stamp->getParameters());
    }

    public function testAddOperation(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->preset('saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('saved', $stamp->getPreset());
        $this->assertEquals([], $stamp->getParameters());
    }

    public function testAddCreated(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->created();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('created', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testAddUpdated(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->updated();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('updated', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testAddSaved(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->saved();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('saved', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testAddDeleted(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->deleted();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('deleted', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testPreset(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->preset('entity_saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('entity_saved', $stamp->getPreset());
        $this->assertEquals([], $stamp->getParameters());
    }

    public function testOperation(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->operation('someOperation');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('someOperation', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testCreated(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->created();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('created', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testUpdated(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->updated();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('updated', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testSaved(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->saved();

        $stamp = $builder->getEnvelope()->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertEquals('saved', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }

    public function testDeleted(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->deleted();

        $stamp = $builder->getEnvelope()->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
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

        array_unshift($stamps, new PluginStamp('flasher'));

        $this->assertEquals($stamps, array_values($all));
    }

    public function testWithStamp(): void
    {
        $builder = $this->getNotificationBuilder();

        $stamp = $this->createMock(StampInterface::class);
        $builder->with($stamp);

        $envelope = $builder->getEnvelope();
        $stamps = $envelope->all();

        $this->assertContains($stamp, $stamps);
    }

    public function testHandler(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->handler('flasher');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PluginStamp::class);

        $this->assertInstanceOf(PluginStamp::class, $stamp);
        $this->assertEquals('flasher', $stamp->getPlugin());
    }

    public function testContext(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->context(['foo' => 'bar']);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(ContextStamp::class);

        $this->assertInstanceOf(ContextStamp::class, $stamp);
        $this->assertEquals(['foo' => 'bar'], $stamp->getContext());
    }

    public function testMacro(): void
    {
        NotificationBuilder::macro('foo', fn (): string => 'Called from a macro');

        $builder = $this->getNotificationBuilder();
        $response = $builder->foo();

        $this->assertTrue(NotificationBuilder::hasMacro('foo'));
        $this->assertEquals('Called from a macro', $response);
    }

    /**
     * @phpstan-param MockObject|StorageManagerInterface $storageManager
     */
    private function getNotificationBuilder(StorageManagerInterface $storageManager = null): NotificationBuilderInterface
    {
        /** @var StorageManagerInterface $storageManager */
        $storageManager = $storageManager ?: $this->createMock(StorageManagerInterface::class);

        return new NotificationBuilder(new Notification(), $storageManager);
    }
}
