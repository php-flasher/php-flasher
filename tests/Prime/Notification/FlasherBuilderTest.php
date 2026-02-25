<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Notification;

use Flasher\Prime\Notification\FlasherBuilder;
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
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class FlasherBuilderTest extends TestCase
{
    public function testAddSuccessMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->success('success message');

        $envelope = $builder->getEnvelope();

        $this->assertSame(Type::SUCCESS, $envelope->getType());
        $this->assertSame('success message', $envelope->getMessage());
    }

    public function testAddErrorMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->error('error message');

        $envelope = $builder->getEnvelope();

        $this->assertSame(Type::ERROR, $envelope->getType());
        $this->assertSame('error message', $envelope->getMessage());
    }

    public function testAddWarningMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->warning('warning message');

        $envelope = $builder->getEnvelope();

        $this->assertSame(Type::WARNING, $envelope->getType());
        $this->assertSame('warning message', $envelope->getMessage());
    }

    public function testAddInfoMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->info('info message');

        $envelope = $builder->getEnvelope();

        $this->assertSame(Type::INFO, $envelope->getType());
        $this->assertSame('info message', $envelope->getMessage());
    }

    public function testAddFlashMessage(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->flash('success', 'success message');

        $envelope = $builder->getEnvelope();

        $this->assertSame(Type::SUCCESS, $envelope->getType());
        $this->assertSame('success message', $envelope->getMessage());
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

        $this->assertSame(Type::SUCCESS, $envelope->getType());
    }

    public function testNotificationMessage(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->message('some message');

        $envelope = $builder->getEnvelope();

        $this->assertSame('some message', $envelope->getMessage());
    }

    public function testNotificationTitle(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->title('some title');

        $envelope = $builder->getEnvelope();

        $this->assertSame('some title', $envelope->getTitle());
    }

    public function testNotificationOptions(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->options(['timeout' => 2000]);

        $envelope = $builder->getEnvelope();

        $this->assertSame(['timeout' => 2000], $envelope->getOptions());
    }

    public function testNotificationOption(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->option('timeout', 2000);

        $envelope = $builder->getEnvelope();

        $this->assertSame(2000, $envelope->getOption('timeout'));
    }

    public function testSuccessType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('success');

        $envelope = $builder->getEnvelope();

        $this->assertSame(Type::SUCCESS, $envelope->getType());
    }

    public function testErrorType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('error');

        $envelope = $builder->getEnvelope();

        $this->assertSame(Type::ERROR, $envelope->getType());
    }

    public function testInfoType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('info');

        $envelope = $builder->getEnvelope();

        $this->assertSame(Type::INFO, $envelope->getType());
    }

    public function testWarningType(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('warning');

        $envelope = $builder->getEnvelope();

        $this->assertSame(Type::WARNING, $envelope->getType());
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
        $this->assertSame(2, $stamp->getPriority());
    }

    public function testHops(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->hops(3);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(HopsStamp::class);

        $this->assertInstanceOf(HopsStamp::class, $stamp);
        $this->assertSame(3, $stamp->getAmount());
    }

    public function testKeep(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->keep();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(HopsStamp::class);

        $this->assertInstanceOf(HopsStamp::class, $stamp);
        $this->assertSame(2, $stamp->getAmount());
    }

    public function testDelay(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->delay(3);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(DelayStamp::class);

        $this->assertInstanceOf(DelayStamp::class, $stamp);
        $this->assertSame(3, $stamp->getDelay());
    }

    public function testTranslate(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->translate(['foo' => 'bar'], 'ar');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(TranslationStamp::class);

        $this->assertInstanceOf(TranslationStamp::class, $stamp);
        $this->assertSame('ar', $stamp->getLocale());
        $this->assertSame(['foo' => 'bar'], $stamp->getParameters());
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
        $this->assertSame('entity_saved', $stamp->getPreset());
        $this->assertSame([], $stamp->getParameters());
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
        $this->assertSame('saved', $stamp->getPreset());
        $this->assertSame([], $stamp->getParameters());
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
        $this->assertSame('created', $stamp->getPreset());
        $this->assertSame([':resource' => 'resource'], $stamp->getParameters());
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
        $this->assertSame('updated', $stamp->getPreset());
        $this->assertSame([':resource' => 'resource'], $stamp->getParameters());
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
        $this->assertSame('saved', $stamp->getPreset());
        $this->assertSame([':resource' => 'resource'], $stamp->getParameters());
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
        $this->assertSame('deleted', $stamp->getPreset());
        $this->assertSame([':resource' => 'resource'], $stamp->getParameters());
    }

    public function testPreset(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->preset('entity_saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertSame('entity_saved', $stamp->getPreset());
        $this->assertSame([], $stamp->getParameters());
    }

    public function testOperation(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->operation('someOperation');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertSame('someOperation', $stamp->getPreset());
        $this->assertSame([':resource' => 'resource'], $stamp->getParameters());
    }

    public function testCreated(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->created();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertSame('created', $stamp->getPreset());
        $this->assertSame([':resource' => 'resource'], $stamp->getParameters());
    }

    public function testUpdated(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->updated();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertSame('updated', $stamp->getPreset());
        $this->assertSame([':resource' => 'resource'], $stamp->getParameters());
    }

    public function testSaved(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->saved();

        $stamp = $builder->getEnvelope()->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertSame('saved', $stamp->getPreset());
        $this->assertSame([':resource' => 'resource'], $stamp->getParameters());
    }

    public function testDeleted(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->deleted();

        $stamp = $builder->getEnvelope()->get(PresetStamp::class);

        $this->assertInstanceOf(PresetStamp::class, $stamp);
        $this->assertSame('deleted', $stamp->getPreset());
        $this->assertSame([':resource' => 'resource'], $stamp->getParameters());
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
        $this->assertSame('flasher', $stamp->getPlugin());
    }

    public function testContext(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->context(['foo' => 'bar']);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(ContextStamp::class);

        $this->assertInstanceOf(ContextStamp::class, $stamp);
        $this->assertSame(['foo' => 'bar'], $stamp->getContext());
    }

    public function testMacro(): void
    {
        NotificationBuilder::macro('foo', fn (): string => 'Called from a macro');

        $builder = $this->getNotificationBuilder();
        $response = $builder->foo(); // @phpstan-ignore-line

        $this->assertTrue(NotificationBuilder::hasMacro('foo'));
        $this->assertSame('Called from a macro', $response);
    }

    public function testTimeout(): void
    {
        $builder = $this->getFlasherBuilder();
        $result = $builder->timeout(5000);

        $this->assertSame($builder, $result);
        $this->assertSame(5000, $builder->getEnvelope()->getOption('timeout'));
    }

    public function testTimeoutWithZero(): void
    {
        $builder = $this->getFlasherBuilder();
        $builder->timeout(0);

        $this->assertSame(0, $builder->getEnvelope()->getOption('timeout'));
    }

    public function testDirection(): void
    {
        $builder = $this->getFlasherBuilder();
        $result = $builder->direction('top');

        $this->assertSame($builder, $result);
        $this->assertSame('top', $builder->getEnvelope()->getOption('direction'));
    }

    public function testDirectionBottom(): void
    {
        $builder = $this->getFlasherBuilder();
        $builder->direction('bottom');

        $this->assertSame('bottom', $builder->getEnvelope()->getOption('direction'));
    }

    public function testPosition(): void
    {
        $builder = $this->getFlasherBuilder();
        $result = $builder->position('top-right');

        $this->assertSame($builder, $result);
        $this->assertSame('top-right', $builder->getEnvelope()->getOption('position'));
    }

    public function testPositionTopLeft(): void
    {
        $builder = $this->getFlasherBuilder();
        $builder->position('top-left');

        $this->assertSame('top-left', $builder->getEnvelope()->getOption('position'));
    }

    public function testPositionBottomCenter(): void
    {
        $builder = $this->getFlasherBuilder();
        $builder->position('bottom-center');

        $this->assertSame('bottom-center', $builder->getEnvelope()->getOption('position'));
    }

    public function testChainingTimeoutDirectionPosition(): void
    {
        $builder = $this->getFlasherBuilder();
        $builder
            ->timeout(3000)
            ->direction('top')
            ->position('top-center');

        $envelope = $builder->getEnvelope();
        $this->assertSame(3000, $envelope->getOption('timeout'));
        $this->assertSame('top', $envelope->getOption('direction'));
        $this->assertSame('top-center', $envelope->getOption('position'));
    }

    public function testFlasherBuilderType(): void
    {
        $builder = $this->getFlasherBuilder();
        $result = $builder->type('success');

        $this->assertSame($builder, $result);
        $this->assertSame(Type::SUCCESS, $builder->getEnvelope()->getType());
    }

    public function testFlasherBuilderSuccessWithOptions(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getFlasherBuilder($storageManager);
        $envelope = $builder->success('Success!', ['timeout' => 2000], 'Title');

        $this->assertSame(Type::SUCCESS, $envelope->getType());
        $this->assertSame('Success!', $envelope->getMessage());
        $this->assertSame('Title', $envelope->getTitle());
        $this->assertSame(2000, $envelope->getOption('timeout'));
    }

    public function testFlasherBuilderErrorWithOptions(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getFlasherBuilder($storageManager);
        $envelope = $builder->error('Error!', ['position' => 'top-left']);

        $this->assertSame(Type::ERROR, $envelope->getType());
        $this->assertSame('top-left', $envelope->getOption('position'));
    }

    public function testFlasherBuilderInfoWithOptions(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getFlasherBuilder($storageManager);
        $envelope = $builder->info('Info!', ['rtl' => true]);

        $this->assertSame(Type::INFO, $envelope->getType());
        $this->assertTrue($envelope->getOption('rtl'));
    }

    public function testFlasherBuilderWarningWithOptions(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getFlasherBuilder($storageManager);
        $envelope = $builder->warning('Warning!', ['escapeHtml' => false]);

        $this->assertSame(Type::WARNING, $envelope->getType());
        $this->assertFalse($envelope->getOption('escapeHtml'));
    }

    public function testFlasherBuilderFlashWithAllParameters(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getFlasherBuilder($storageManager);
        $envelope = $builder->flash('error', 'Flash message', ['fps' => 60], 'Flash Title');

        $this->assertSame(Type::ERROR, $envelope->getType());
        $this->assertSame('Flash message', $envelope->getMessage());
        $this->assertSame('Flash Title', $envelope->getTitle());
        $this->assertSame(60, $envelope->getOption('fps'));
    }

    public function testFlasherBuilderOptions(): void
    {
        $builder = $this->getFlasherBuilder();
        $result = $builder->options(['timeout' => 1000, 'position' => 'bottom-right']);

        $this->assertSame($builder, $result);
        $this->assertSame(1000, $builder->getEnvelope()->getOption('timeout'));
        $this->assertSame('bottom-right', $builder->getEnvelope()->getOption('position'));
    }

    public function testFlasherBuilderOption(): void
    {
        $builder = $this->getFlasherBuilder();
        $result = $builder->option('style', ['background' => '#fff']);

        $this->assertSame($builder, $result);
        $this->assertSame(['background' => '#fff'], $builder->getEnvelope()->getOption('style'));
    }

    public function testKeepWithExistingHopsStamp(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->hops(3); // First set hops to 3
        $builder->keep();  // Should add 1 to existing 3 = 4

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(HopsStamp::class);

        $this->assertInstanceOf(HopsStamp::class, $stamp);
        $this->assertSame(4, $stamp->getAmount());
    }

    public function testWhenWithExistingWhenStamp(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->when(true);
        $builder->when(true);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(WhenStamp::class);

        $this->assertInstanceOf(WhenStamp::class, $stamp);
        $this->assertTrue($stamp->getCondition());
    }

    public function testWhenWithExistingWhenStampBecomesFalse(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->when(true);
        $builder->when(false);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(WhenStamp::class);

        $this->assertInstanceOf(WhenStamp::class, $stamp);
        $this->assertFalse($stamp->getCondition());
    }

    public function testUnlessWithExistingUnlessStamp(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->unless(false);
        $builder->unless(false);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(UnlessStamp::class);

        $this->assertInstanceOf(UnlessStamp::class, $stamp);
        $this->assertFalse($stamp->getCondition());
    }

    public function testUnlessWithExistingUnlessStampBecomesTrue(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->unless(false);
        $builder->unless(true);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(UnlessStamp::class);

        $this->assertInstanceOf(UnlessStamp::class, $stamp);
        $this->assertTrue($stamp->getCondition());
    }

    public function testWhenWithClosure(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->when(fn () => true);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(WhenStamp::class);

        $this->assertInstanceOf(WhenStamp::class, $stamp);
        $this->assertTrue($stamp->getCondition());
    }

    public function testUnlessWithClosure(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->unless(fn () => false);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get(UnlessStamp::class);

        $this->assertInstanceOf(UnlessStamp::class, $stamp);
        $this->assertFalse($stamp->getCondition());
    }

    public function testWhenWithClosureReturningNonBoolean(): void
    {
        $builder = $this->getNotificationBuilder();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The condition must be a boolean or a closure that returns a boolean');

        $builder->when(fn () => 'string');
    }

    public function testUnlessWithClosureReturningNonBoolean(): void
    {
        $builder = $this->getNotificationBuilder();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The condition must be a boolean or a closure that returns a boolean');

        $builder->unless(fn () => 123);
    }

    public function testOptionsWithAppendFalse(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->options(['timeout' => 5000, 'direction' => 'top']);
        // With append=false, we pass only new options but setOptions uses array_replace
        $builder->options(['timeout' => 3000], false);

        $envelope = $builder->getEnvelope();

        // array_replace replaces existing keys, so timeout changes but direction remains
        $this->assertSame(3000, $envelope->getOption('timeout'));
        $this->assertSame('top', $envelope->getOption('direction'));
    }

    public function testOptionsWithAppendTrue(): void
    {
        $builder = $this->getNotificationBuilder();
        $builder->options(['timeout' => 5000]);
        $builder->options(['position' => 'top-right'], true);

        $envelope = $builder->getEnvelope();

        $this->assertSame(5000, $envelope->getOption('timeout'));
        $this->assertSame('top-right', $envelope->getOption('position'));
    }

    /**
     * @phpstan-param MockObject|StorageManagerInterface $storageManager
     */
    private function getNotificationBuilder(?StorageManagerInterface $storageManager = null): NotificationBuilderInterface
    {
        /** @var StorageManagerInterface $storageManager */
        $storageManager = $storageManager ?: $this->createMock(StorageManagerInterface::class);

        return new FlasherBuilder(new Notification(), $storageManager);
    }

    /**
     * @phpstan-param MockObject|StorageManagerInterface $storageManager
     */
    private function getFlasherBuilder(?StorageManagerInterface $storageManager = null): FlasherBuilder
    {
        /** @var StorageManagerInterface $storageManager */
        $storageManager = $storageManager ?: $this->createMock(StorageManagerInterface::class);

        return new FlasherBuilder(new Notification(), $storageManager);
    }
}
