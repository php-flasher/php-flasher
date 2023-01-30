<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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

class NotificationBuilderTest extends TestCase
{
    /**
     * @return void
     */
    public function testAddSuccessMessage()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addSuccess('success message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::SUCCESS, $envelope->getType());
        $this->assertEquals('success message', $envelope->getMessage());
    }

    /**
     * @return void
     */
    public function testAddErrorMessage()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addError('error message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::ERROR, $envelope->getType());
        $this->assertEquals('error message', $envelope->getMessage());
    }

    /**
     * @return void
     */
    public function testAddWarningMessage()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addWarning('warning message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::WARNING, $envelope->getType());
        $this->assertEquals('warning message', $envelope->getMessage());
    }

    /**
     * @return void
     */
    public function testAddInfoMessage()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addInfo('info message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::INFO, $envelope->getType());
        $this->assertEquals('info message', $envelope->getMessage());
    }

    /**
     * @return void
     */
    public function testAddFlashMessage()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addFlash('success', 'success message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::SUCCESS, $envelope->getType());
        $this->assertEquals('success message', $envelope->getMessage());
    }

    /**
     * @return void
     */
    public function testPushToStorage()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->push();
    }

    /**
     * @return void
     */
    public function testNotificationType()
    {
        $builder = $this->getNotificationBuilder();
        $builder->type('success');

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::SUCCESS, $envelope->getType());
    }

    /**
     * @return void
     */
    public function testNotificationMessage()
    {
        $builder = $this->getNotificationBuilder();
        $builder->message('some message');

        $envelope = $builder->getEnvelope();

        $this->assertEquals('some message', $envelope->getMessage());
    }

    /**
     * @return void
     */
    public function testNotificationTitle()
    {
        $builder = $this->getNotificationBuilder();
        $builder->title('some title');

        $envelope = $builder->getEnvelope();

        $this->assertEquals('some title', $envelope->getTitle());
    }

    /**
     * @return void
     */
    public function testNotificationOptions()
    {
        $builder = $this->getNotificationBuilder();
        $builder->options(array('timeout' => 2000));

        $envelope = $builder->getEnvelope();

        $this->assertEquals(array('timeout' => 2000), $envelope->getOptions());
    }

    /**
     * @return void
     */
    public function testNotificationOption()
    {
        $builder = $this->getNotificationBuilder();
        $builder->option('timeout', 2000);

        $envelope = $builder->getEnvelope();

        $this->assertEquals(2000, $envelope->getOption('timeout'));
    }

    /**
     * @return void
     */
    public function testSuccessType()
    {
        $builder = $this->getNotificationBuilder();
        $builder->success();

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::SUCCESS, $envelope->getType());
    }

    /**
     * @return void
     */
    public function testErrorType()
    {
        $builder = $this->getNotificationBuilder();
        $builder->error();

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::ERROR, $envelope->getType());
    }

    /**
     * @return void
     */
    public function testInfoType()
    {
        $builder = $this->getNotificationBuilder();
        $builder->info();

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::INFO, $envelope->getType());
    }

    /**
     * @return void
     */
    public function testWarningType()
    {
        $builder = $this->getNotificationBuilder();
        $builder->warning();

        $envelope = $builder->getEnvelope();

        $this->assertEquals(NotificationInterface::WARNING, $envelope->getType());
    }

    /**
     * @return void
     */
    public function testWhenCondition()
    {
        $builder = $this->getNotificationBuilder();
        $builder->when(true);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\WhenStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\WhenStamp', $stamp);
        $this->assertEquals(true, $stamp->getCondition());
    }

    /**
     * @return void
     */
    public function testUnlessCondition()
    {
        $builder = $this->getNotificationBuilder();
        $builder->unless(true);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\UnlessStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\UnlessStamp', $stamp);
        $this->assertEquals(true, $stamp->getCondition());
    }

    /**
     * @return void
     */
    public function testPriority()
    {
        $builder = $this->getNotificationBuilder();
        $builder->priority(2);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PriorityStamp', $stamp);
        $this->assertEquals(2, $stamp->getPriority());
    }

    /**
     * @return void
     */
    public function testHops()
    {
        $builder = $this->getNotificationBuilder();
        $builder->hops(3);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\HopsStamp', $stamp);
        $this->assertEquals(3, $stamp->getAmount());
    }

    /**
     * @return void
     */
    public function testKeep()
    {
        $builder = $this->getNotificationBuilder();
        $builder->keep();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\HopsStamp', $stamp);
        $this->assertEquals(2, $stamp->getAmount());
    }

    /**
     * @return void
     */
    public function testDelay()
    {
        $builder = $this->getNotificationBuilder();
        $builder->delay(3);

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\DelayStamp', $stamp);
        $this->assertEquals(3, $stamp->getDelay());
    }

    /**
     * @return void
     */
    public function testNow()
    {
        $builder = $this->getNotificationBuilder();
        $builder->now();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\DelayStamp', $stamp);
        $this->assertEquals(0, $stamp->getDelay());
    }

    /**
     * @return void
     */
    public function testTranslate()
    {
        $builder = $this->getNotificationBuilder();
        $builder->translate(array('foo' => 'bar'), 'ar');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\TranslationStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\TranslationStamp', $stamp);
        $this->assertEquals('ar', $stamp->getLocale());
        $this->assertEquals(array('foo' => 'bar'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testAddPreset()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addPreset('entity_saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('entity_saved', $stamp->getPreset());
        $this->assertEquals(array(), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testAddOperation()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addPreset('saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('saved', $stamp->getPreset());
        $this->assertEquals(array(), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testAddCreated()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addCreated();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('created', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testAddUpdated()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addUpdated();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('updated', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testAddSaved()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addSaved();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('saved', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testAddDeleted()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $builder = $this->getNotificationBuilder($storageManager);
        $builder->addDeleted();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('deleted', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testPreset()
    {
        $builder = $this->getNotificationBuilder();
        $builder->preset('entity_saved');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('entity_saved', $stamp->getPreset());
        $this->assertEquals(array(), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testOperation()
    {
        $builder = $this->getNotificationBuilder();
        $builder->operation('someOperation');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('someOperation', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testCreated()
    {
        $builder = $this->getNotificationBuilder();
        $builder->created();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('created', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testUpdated()
    {
        $builder = $this->getNotificationBuilder();
        $builder->updated();

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('updated', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testSaved()
    {
        $builder = $this->getNotificationBuilder();
        $builder->saved();

        $stamp = $builder->getEnvelope()->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('saved', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testDeleted()
    {
        $builder = $this->getNotificationBuilder();
        $builder->deleted();

        $stamp = $builder->getEnvelope()->get('Flasher\Prime\Stamp\PresetStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\PresetStamp', $stamp);
        $this->assertEquals('deleted', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }

    /**
     * @return void
     */
    public function testWithStamps()
    {
        $builder = $this->getNotificationBuilder();

        $stamps = array(
            new PriorityStamp(1),
            new HopsStamp(0),
        );
        $builder->with($stamps);

        $envelope = $builder->getEnvelope();
        $all = $envelope->all();

        $this->assertEquals($stamps, array_values($all));
    }

    /**
     * @return void
     */
    public function testWithStamp()
    {
        $builder = $this->getNotificationBuilder();

        $stamp = $this->getMockBuilder('Flasher\Prime\Stamp\StampInterface')->getMock();
        $builder->withStamp($stamp);

        $envelope = $builder->getEnvelope();
        $stamps = $envelope->all();

        $this->assertContains($stamp, $stamps);
    }

    /**
     * @return void
     */
    public function testHandler()
    {
        $builder = $this->getNotificationBuilder();
        $builder->handler('flasher');

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\HandlerStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\HandlerStamp', $stamp);
        $this->assertEquals('flasher', $stamp->getHandler());
    }

    /**
     * @return void
     */
    public function testContext()
    {
        $builder = $this->getNotificationBuilder();
        $builder->context(array('foo' => 'bar'));

        $envelope = $builder->getEnvelope();
        $stamp = $envelope->get('Flasher\Prime\Stamp\ContextStamp');

        $this->assertInstanceOf('Flasher\Prime\Stamp\ContextStamp', $stamp);
        $this->assertEquals(array('foo' => 'bar'), $stamp->getContext());
    }

    /**
     * @return void
     */
    public function testMacro()
    {
        if (version_compare(PHP_VERSION, '5.4', '<')) {
            $this->markTestSkipped('Not working for PHP 5.3');
        }

        NotificationBuilder::macro('foo', function () {
            return 'Called from a macro';
        });

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
    private function getNotificationBuilder(StorageManagerInterface $storageManager = null)
    {
        /** @var StorageManagerInterface $storageManager */
        $storageManager = $storageManager ?: $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();

        return new NotificationBuilder($storageManager, new Notification());
    }
}
