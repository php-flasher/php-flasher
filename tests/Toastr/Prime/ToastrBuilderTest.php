<?php

declare(strict_types=1);

namespace Flasher\Tests\Toastr\Prime;

use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Toastr\Prime\ToastrBuilder;
use PHPUnit\Framework\TestCase;

final class ToastrBuilderTest extends TestCase
{
    private ToastrBuilder $toastrBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);
        $this->toastrBuilder = new ToastrBuilder('toastr', $storageManagerMock);
    }

    public function testCloseButton(): void
    {
        $this->toastrBuilder->closeButton(true);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeButton' => true], $options);
    }

    public function testCloseClass(): void
    {
        $this->toastrBuilder->closeClass('.close');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeClass' => '.close'], $options);
    }

    public function testCloseDuration(): void
    {
        $this->toastrBuilder->closeDuration(6000);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeDuration' => 6000], $options);
    }

    public function testCloseEasing(): void
    {
        $this->toastrBuilder->closeEasing('closing');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeEasing' => 'closing'], $options);
    }

    public function testCloseHtml(): void
    {
        $this->toastrBuilder->closeHtml('<button>x</button>');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeHtml' => '<button>x</button>'], $options);
    }

    public function testCloseMethod(): void
    {
        $this->toastrBuilder->closeMethod('fadeOut');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeMethod' => 'fadeOut'], $options);
    }

    public function testCloseOnHover(): void
    {
        $this->toastrBuilder->closeOnHover(false);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeOnHover' => false], $options);
    }

    public function testContainerId(): void
    {
        $this->toastrBuilder->containerId('myContainer');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['containerId' => 'myContainer'], $options);
    }

    public function testDebug(): void
    {
        $this->toastrBuilder->debug(false);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['debug' => false], $options);
    }

    public function testEscapeHtml(): void
    {
        $this->toastrBuilder->escapeHtml(false);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['escapeHtml' => false], $options);
    }

    public function testExtendedTimeOut(): void
    {
        $this->toastrBuilder->extendedTimeOut(10000);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['extendedTimeOut' => 10000], $options);
    }

    public function testHideDuration(): void
    {
        $this->toastrBuilder->hideDuration(3000);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['hideDuration' => 3000], $options);
    }

    public function testHideEasing(): void
    {
        $this->toastrBuilder->hideEasing('linear');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['hideEasing' => 'linear'], $options);
    }

    public function testHideMethod(): void
    {
        $this->toastrBuilder->hideMethod('slideUp');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['hideMethod' => 'slideUp'], $options);
    }

    public function testIconClass(): void
    {
        $this->toastrBuilder->iconClass('icon-info');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['iconClass' => 'icon-info'], $options);
    }

    public function testMessageClass(): void
    {
        $this->toastrBuilder->messageClass('message-info');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['messageClass' => 'message-info'], $options);
    }

    public function testNewestOnTop(): void
    {
        $this->toastrBuilder->newestOnTop(false);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['newestOnTop' => false], $options);
    }

    public function testOnHidden(): void
    {
        $this->toastrBuilder->onHidden('hiddenCallback');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['onHidden' => 'hiddenCallback'], $options);
    }

    public function testOnShown(): void
    {
        $this->toastrBuilder->onShown('shownCallback');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['onShown' => 'shownCallback'], $options);
    }

    public function testPositionClass(): void
    {
        $this->toastrBuilder->positionClass('toast-top-right');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['positionClass' => 'toast-top-right'], $options);
    }

    public function testPreventDuplicates(): void
    {
        $this->toastrBuilder->preventDuplicates();

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['preventDuplicates' => true], $options);
    }

    public function testProgressBar(): void
    {
        $this->toastrBuilder->progressBar();

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['progressBar' => true], $options);
    }

    public function testProgressClass(): void
    {
        $this->toastrBuilder->progressClass('progress-info');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['progressClass' => 'progress-info'], $options);
    }

    public function testRtl(): void
    {
        $this->toastrBuilder->rtl(true);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['rtl' => true], $options);
    }

    public function testShowDuration(): void
    {
        $this->toastrBuilder->showDuration(500);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['showDuration' => 500], $options);
    }

    public function testShowEasing(): void
    {
        $this->toastrBuilder->showEasing('easeIn');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['showEasing' => 'easeIn'], $options);
    }

    public function testShowMethod(): void
    {
        $this->toastrBuilder->showMethod('slideDown');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['showMethod' => 'slideDown'], $options);
    }

    public function testTapToDismiss(): void
    {
        $this->toastrBuilder->tapToDismiss(false);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['tapToDismiss' => false], $options);
    }

    public function testTarget(): void
    {
        $this->toastrBuilder->target('#myTarget');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['target' => '#myTarget'], $options);
    }

    public function testTimeOut(): void
    {
        $this->toastrBuilder->timeOut(3000, 1000);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['timeOut' => 3000, 'extendedTimeOut' => 1000], $options);
    }

    public function testTitleClass(): void
    {
        $this->toastrBuilder->titleClass('title-info');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['titleClass' => 'title-info'], $options);
    }

    public function testToastClass(): void
    {
        $this->toastrBuilder->toastClass('toast-info');

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['toastClass' => 'toast-info'], $options);
    }

    public function testPersistent(): void
    {
        $this->toastrBuilder->persistent();

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['timeOut' => 0, 'extendedTimeOut' => 0], $options);
    }

    public function testTimeOutWithoutExtended(): void
    {
        $this->toastrBuilder->timeOut(5000);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['timeOut' => 5000], $options);
    }

    public function testCloseButtonFalse(): void
    {
        $this->toastrBuilder->closeButton(false);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeButton' => false], $options);
    }

    public function testCloseOnHoverTrue(): void
    {
        $this->toastrBuilder->closeOnHover(true);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeOnHover' => true], $options);
    }

    public function testDebugTrue(): void
    {
        $this->toastrBuilder->debug(true);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['debug' => true], $options);
    }

    public function testEscapeHtmlTrue(): void
    {
        $this->toastrBuilder->escapeHtml(true);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['escapeHtml' => true], $options);
    }

    public function testNewestOnTopTrue(): void
    {
        $this->toastrBuilder->newestOnTop(true);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['newestOnTop' => true], $options);
    }

    public function testPreventDuplicatesFalse(): void
    {
        $this->toastrBuilder->preventDuplicates(false);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['preventDuplicates' => false], $options);
    }

    public function testProgressBarFalse(): void
    {
        $this->toastrBuilder->progressBar(false);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['progressBar' => false], $options);
    }

    public function testRtlFalse(): void
    {
        $this->toastrBuilder->rtl(false);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['rtl' => false], $options);
    }

    public function testTapToDismissTrue(): void
    {
        $this->toastrBuilder->tapToDismiss(true);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['tapToDismiss' => true], $options);
    }

    public function testTypeMethod(): void
    {
        $this->toastrBuilder->type('success');

        $envelope = $this->toastrBuilder->getEnvelope();
        $this->assertSame('success', $envelope->getNotification()->getType());
    }

    public function testSuccessMethod(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);
        $storageManagerMock->expects('add')->once();

        $builder = new ToastrBuilder('toastr', $storageManagerMock);
        $envelope = $builder->success('Success message', ['timeout' => 3000], 'Title');

        $this->assertSame('success', $envelope->getNotification()->getType());
        $this->assertSame('Success message', $envelope->getNotification()->getMessage());
        $this->assertSame('Title', $envelope->getNotification()->getTitle());
        $this->assertSame(3000, $envelope->getNotification()->getOption('timeout'));
    }

    public function testErrorMethod(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);
        $storageManagerMock->expects('add')->once();

        $builder = new ToastrBuilder('toastr', $storageManagerMock);
        $envelope = $builder->error('Error message');

        $this->assertSame('error', $envelope->getNotification()->getType());
        $this->assertSame('Error message', $envelope->getNotification()->getMessage());
    }

    public function testInfoMethod(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);
        $storageManagerMock->expects('add')->once();

        $builder = new ToastrBuilder('toastr', $storageManagerMock);
        $envelope = $builder->info('Info message');

        $this->assertSame('info', $envelope->getNotification()->getType());
    }

    public function testWarningMethod(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);
        $storageManagerMock->expects('add')->once();

        $builder = new ToastrBuilder('toastr', $storageManagerMock);
        $envelope = $builder->warning('Warning message');

        $this->assertSame('warning', $envelope->getNotification()->getType());
    }

    public function testFlashMethod(): void
    {
        $storageManagerMock = \Mockery::mock(StorageManagerInterface::class);
        $storageManagerMock->expects('add')->once();

        $builder = new ToastrBuilder('toastr', $storageManagerMock);
        $envelope = $builder->flash('info', 'Flash message', ['debug' => true], 'Flash Title');

        $this->assertSame('info', $envelope->getNotification()->getType());
        $this->assertSame('Flash message', $envelope->getNotification()->getMessage());
        $this->assertSame('Flash Title', $envelope->getNotification()->getTitle());
        $this->assertTrue($envelope->getNotification()->getOption('debug'));
    }

    public function testOptionsMethod(): void
    {
        $this->toastrBuilder->options(['timeout' => 5000, 'debug' => true]);

        $envelope = $this->toastrBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(5000, $options['timeout']);
        $this->assertTrue($options['debug']);
    }

    public function testOptionMethod(): void
    {
        $this->toastrBuilder->option('customOption', 'customValue');

        $envelope = $this->toastrBuilder->getEnvelope();
        $this->assertSame('customValue', $envelope->getNotification()->getOption('customOption'));
    }
}
