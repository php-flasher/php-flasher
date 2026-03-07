<?php

declare(strict_types=1);

namespace Flasher\Tests\SweetAlert\Prime;

use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\SweetAlert\Prime\SweetAlertBuilder;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class SweetAlertBuilderTest extends TestCase
{
    private MockInterface&StorageManagerInterface $storageManagerMock;
    private SweetAlertBuilder $sweetAlertBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storageManagerMock = \Mockery::mock(StorageManagerInterface::class);
        $this->sweetAlertBuilder = new SweetAlertBuilder('sweetAlert', $this->storageManagerMock);
    }

    public function testQuestion(): void
    {
        $this->sweetAlertBuilder->question('Are you sure?', ['option1' => 'value1']);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['showCancelButton' => true, 'text' => 'Are you sure?', 'option1' => 'value1'], $options);
    }

    public function testTitle(): void
    {
        $this->sweetAlertBuilder->title('My Title');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['title' => 'My Title'], $options);
    }

    public function testTitleText(): void
    {
        $this->sweetAlertBuilder->titleText('Title Text');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['titleText' => 'Title Text'], $options);
    }

    public function testHtml(): void
    {
        $this->sweetAlertBuilder->html('<p>HTML Content</p>');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['html' => '<p>HTML Content</p>'], $options);
    }

    public function testText(): void
    {
        $this->sweetAlertBuilder->text('Simple text');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['text' => 'Simple text'], $options);
    }

    public function testIcon(): void
    {
        $this->sweetAlertBuilder->icon('success');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['icon' => 'success'], $options);
    }

    public function testIconColor(): void
    {
        $this->sweetAlertBuilder->iconColor('#FF0000');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['iconColor' => '#FF0000'], $options);
    }

    public function testIconHtml(): void
    {
        $this->sweetAlertBuilder->iconHtml('<b>*</b>');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['iconHtml' => '<b>*</b>'], $options);
    }

    public function testShowClass(): void
    {
        $this->sweetAlertBuilder->showClass('popup', 'animate__animated animate__fadeInDown');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $expected = ['showClass' => ['popup' => 'animate__animated animate__fadeInDown']];
        $this->assertSame($expected, $options);
    }

    public function testHideClass(): void
    {
        $this->sweetAlertBuilder->hideClass('popup', 'animate__animated animate__fadeOutUp');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $expected = ['hideClass' => ['popup' => 'animate__animated animate__fadeOutUp']];
        $this->assertSame($expected, $options);
    }

    public function testFooter(): void
    {
        $this->sweetAlertBuilder->footer('Footer text');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['footer' => 'Footer text'], $options);
    }

    public function testBackdrop(): void
    {
        $this->sweetAlertBuilder->backdrop(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['backdrop' => false], $options);
    }

    public function testToast(): void
    {
        $this->sweetAlertBuilder->toast(true, 'top-end', false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $expected = ['toast' => true, 'position' => 'top-end', 'showConfirmButton' => false, 'title' => ' '];
        $this->assertEquals($expected, $options);
    }

    public function testTarget(): void
    {
        $this->sweetAlertBuilder->target('#my-target');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['target' => '#my-target'], $options);
    }

    public function testInputLabel(): void
    {
        $this->sweetAlertBuilder->inputLabel('Input Label');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['inputLabel' => 'Input Label'], $options);
    }

    public function testInputPlaceholder(): void
    {
        $this->sweetAlertBuilder->inputPlaceholder('Placeholder');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['inputPlaceholder' => 'Placeholder'], $options);
    }

    public function testInputValue(): void
    {
        $this->sweetAlertBuilder->inputValue('Value');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['inputValue' => 'Value'], $options);
    }

    public function testInputOptions(): void
    {
        $this->sweetAlertBuilder->inputOptions('Options');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['inputOptions' => 'Options'], $options);
    }

    public function testInputAutoTrim(): void
    {
        $this->sweetAlertBuilder->inputAutoTrim(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['inputAutoTrim' => false], $options);
    }

    public function testInputAttributes(): void
    {
        $this->sweetAlertBuilder->inputAttributes('Attributes');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['inputAttributes' => 'Attributes'], $options);
    }

    public function testInputValidator(): void
    {
        $this->sweetAlertBuilder->inputValidator('Validator');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['inputValidator' => 'Validator'], $options);
    }

    public function testValidationMessage(): void
    {
        $this->sweetAlertBuilder->validationMessage('Validation Message');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['validationMessage' => 'Validation Message'], $options);
    }

    public function testInput(): void
    {
        $this->sweetAlertBuilder->input('text');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['input' => 'text'], $options);
    }

    public function testWidth(): void
    {
        $this->sweetAlertBuilder->width('400px');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['width' => '400px'], $options);
    }

    public function testPadding(): void
    {
        $this->sweetAlertBuilder->padding('20px');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['padding' => '20px'], $options);
    }

    public function testBackground(): void
    {
        $this->sweetAlertBuilder->background('#000');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['background' => '#000'], $options);
    }

    public function testGrow(): void
    {
        $this->sweetAlertBuilder->grow('row');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['grow' => 'row'], $options);
    }

    public function testCustomClass(): void
    {
        $this->sweetAlertBuilder->customClass('confirmButton', 'btn btn-primary');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $expected = ['customClass' => ['confirmButton' => 'btn btn-primary']];
        $this->assertSame($expected, $options);
    }

    public function testTimer(): void
    {
        $this->sweetAlertBuilder->timer(5000);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['timer' => 5000], $options);
    }

    public function testTimerProgressBar(): void
    {
        $this->sweetAlertBuilder->timerProgressBar(true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['timerProgressBar' => true], $options);
    }

    public function testHeightAuto(): void
    {
        $this->sweetAlertBuilder->heightAuto(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['heightAuto' => false], $options);
    }

    public function testAllowOutsideClick(): void
    {
        $this->sweetAlertBuilder->allowOutsideClick(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['allowOutsideClick' => false], $options);
    }

    public function testAllowEscapeKey(): void
    {
        $this->sweetAlertBuilder->allowEscapeKey(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['allowEscapeKey' => false], $options);
    }

    public function testAllowEnterKey(): void
    {
        $this->sweetAlertBuilder->allowEnterKey(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['allowEnterKey' => false], $options);
    }

    public function testStopKeydownPropagation(): void
    {
        $this->sweetAlertBuilder->stopKeydownPropagation(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['stopKeydownPropagation' => false], $options);
    }

    public function testKeydownListenerCapture(): void
    {
        $this->sweetAlertBuilder->keydownListenerCapture(true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['keydownListenerCapture' => true], $options);
    }

    public function testPreConfirm(): void
    {
        $this->sweetAlertBuilder->preConfirm('function() { return true; }');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['preConfirm' => 'function() { return true; }'], $options);
    }

    public function testPreDeny(): void
    {
        $this->sweetAlertBuilder->preDeny('function() { return true; }');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['preDeny' => 'function() { return true; }'], $options);
    }

    public function testReturnInputValueOnDeny(): void
    {
        $this->sweetAlertBuilder->returnInputValueOnDeny(true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['returnInputValueOnDeny' => true], $options);
    }

    public function testAnimation(): void
    {
        $this->sweetAlertBuilder->animation(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['animation' => false], $options);
    }

    public function testPersistent(): void
    {
        $this->sweetAlertBuilder->persistent(true, true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['allowEscapeKey' => false, 'allowOutsideClick' => false, 'timer' => 0, 'showConfirmButton' => true, 'showCloseButton' => true], $options);
    }

    public function testImageUrl(): void
    {
        $this->sweetAlertBuilder->imageUrl('path/to/image.jpg', 100, 100, 'Image Alt');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $expected = ['imageUrl' => 'path/to/image.jpg', 'imageWidth' => 100, 'imageHeight' => 100, 'imageAlt' => 'Image Alt'];
        $this->assertSame($expected, $options);
    }

    public function testImageWidth(): void
    {
        $this->sweetAlertBuilder->imageWidth(200);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['imageWidth' => 200], $options);
    }

    public function testImageHeight(): void
    {
        $this->sweetAlertBuilder->imageHeight(200);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['imageHeight' => 200], $options);
    }

    public function testImageAlt(): void
    {
        $this->sweetAlertBuilder->imageAlt('Alternative Text');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['imageAlt' => 'Alternative Text'], $options);
    }

    public function testImage(): void
    {
        $this->sweetAlertBuilder->image('Title', 'Text', 'path/to/image.jpg', 300, 150, 'Alt Text');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $expected = ['title' => 'Title', 'text' => 'Text', 'imageUrl' => 'path/to/image.jpg', 'imageWidth' => 300, 'imageHeight' => 150, 'animation' => false, 'imageAlt' => 'Alt Text'];
        $this->assertEquals($expected, $options);
    }

    public function testAddImage(): void
    {
        $this->storageManagerMock->expects('add');

        $envelope = $this->sweetAlertBuilder->addImage('Title', 'Text', 'path/to/image.jpg', 300, 150, 'Alt Text');

        $options = $envelope->getNotification()->getOptions();

        $expected = ['title' => 'Title', 'text' => 'Text', 'imageUrl' => 'path/to/image.jpg', 'imageWidth' => 300, 'imageHeight' => 150, 'animation' => false, 'imageAlt' => 'Alt Text'];
        $this->assertEquals($expected, $options);
    }

    public function testShowDenyButton(): void
    {
        $this->sweetAlertBuilder->showDenyButton(true, 'Deny', '#FF0000', 'Deny this');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $expected = [
            'showDenyButton' => true,
            'denyButtonText' => 'Deny',
            'denyButtonColor' => '#FF0000',
            'denyButtonAriaLabel' => 'Deny this',
        ];
        $this->assertSame($expected, $options);
    }

    public function testButtonsStyling(): void
    {
        $this->sweetAlertBuilder->buttonsStyling(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['buttonsStyling' => false], $options);
    }

    public function testReverseButtons(): void
    {
        $this->sweetAlertBuilder->reverseButtons(true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['reverseButtons' => true], $options);
    }

    public function testFocusConfirm(): void
    {
        $this->sweetAlertBuilder->focusConfirm(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['focusConfirm' => false], $options);
    }

    public function testFocusDeny(): void
    {
        $this->sweetAlertBuilder->focusDeny(true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['focusDeny' => true], $options);
    }

    public function testFocusCancel(): void
    {
        $this->sweetAlertBuilder->focusCancel(true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['focusCancel' => true], $options);
    }

    public function testCloseButtonHtml(): void
    {
        $this->sweetAlertBuilder->closeButtonHtml('<span>Close</span>');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeButtonHtml' => '<span>Close</span>'], $options);
    }

    public function testCloseButtonAriaLabel(): void
    {
        $this->sweetAlertBuilder->closeButtonAriaLabel('Close this popup');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['closeButtonAriaLabel' => 'Close this popup'], $options);
    }

    public function testLoaderHtml(): void
    {
        $this->sweetAlertBuilder->loaderHtml('<div>Loading...</div>');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['loaderHtml' => '<div>Loading...</div>'], $options);
    }

    public function testShowLoaderOnConfirm(): void
    {
        $this->sweetAlertBuilder->showLoaderOnConfirm(true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['showLoaderOnConfirm' => true], $options);
    }

    public function testScrollbarPadding(): void
    {
        $this->sweetAlertBuilder->scrollbarPadding(false);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['scrollbarPadding' => false], $options);
    }

    public function testShowConfirmButtonWithAllParameters(): void
    {
        $this->sweetAlertBuilder->showConfirmButton(true, 'OK', '#3085d6', 'Confirm button');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame([
            'showConfirmButton' => true,
            'confirmButtonText' => 'OK',
            'confirmButtonColor' => '#3085d6',
            'confirmButtonAriaLabel' => 'Confirm button',
        ], $options);
    }

    public function testShowCancelButtonWithAllParameters(): void
    {
        $this->sweetAlertBuilder->showCancelButton(true, 'Cancel', '#d33', 'Cancel button');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame([
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#d33',
            'cancelButtonAriaLabel' => 'Cancel button',
        ], $options);
    }

    public function testConfirmButtonTextWithAllParameters(): void
    {
        $this->sweetAlertBuilder->confirmButtonText('Confirm', '#28a745', 'Confirm action');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame([
            'confirmButtonText' => 'Confirm',
            'confirmButtonColor' => '#28a745',
            'confirmButtonAriaLabel' => 'Confirm action',
        ], $options);
    }

    public function testDenyButtonTextWithAllParameters(): void
    {
        $this->sweetAlertBuilder->denyButtonText('Deny', '#dc3545', 'Deny action');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame([
            'denyButtonText' => 'Deny',
            'denyButtonColor' => '#dc3545',
            'denyButtonAriaLabel' => 'Deny action',
        ], $options);
    }

    public function testCancelButtonTextWithAllParameters(): void
    {
        $this->sweetAlertBuilder->cancelButtonText('No', '#6c757d', 'Cancel and go back');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame([
            'cancelButtonText' => 'No',
            'cancelButtonColor' => '#6c757d',
            'cancelButtonAriaLabel' => 'Cancel and go back',
        ], $options);
    }

    public function testImageUrlWithPartialParameters(): void
    {
        $this->sweetAlertBuilder->imageUrl('path/to/image.jpg', 100);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame([
            'imageUrl' => 'path/to/image.jpg',
            'imageWidth' => 100,
        ], $options);
    }

    public function testImageWithoutAltUsesTitle(): void
    {
        $this->sweetAlertBuilder->image('My Title', 'My Text', 'image.jpg', 400, 200);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame('My Title', $options['imageAlt']);
    }

    public function testMessages(): void
    {
        $this->sweetAlertBuilder->messages('Test message');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $notification = $envelope->getNotification();

        $this->assertSame('Test message', $notification->getMessage());
        $this->assertSame('Test message', $notification->getOptions()['text']);
    }

    public function testPosition(): void
    {
        $this->sweetAlertBuilder->position('top-start');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['position' => 'top-start'], $options);
    }

    public function testShowCloseButton(): void
    {
        $this->sweetAlertBuilder->showCloseButton(true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['showCloseButton' => true], $options);
    }

    public function testToastWithExistingTitle(): void
    {
        $this->sweetAlertBuilder->title('Existing Title');
        $this->sweetAlertBuilder->toast(true, 'bottom-end', true);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        // Title should remain as set, not be overridden with ' '
        $this->assertSame('Existing Title', $options['title']);
    }

    public function testQuestionWithoutMessage(): void
    {
        $this->sweetAlertBuilder->question();

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame('question', $envelope->getType());
        $this->assertTrue($options['showCancelButton']);
    }

    public function testQuestionWithOptions(): void
    {
        $this->sweetAlertBuilder->question('Are you sure?', ['timer' => 5000]);

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $notification = $envelope->getNotification();

        $this->assertSame('question', $envelope->getType());
        $this->assertSame('Are you sure?', $notification->getMessage());
    }

    public function testDenyButtonColor(): void
    {
        $this->sweetAlertBuilder->denyButtonColor('#dc3545');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['denyButtonColor' => '#dc3545'], $options);
    }

    public function testCancelButtonColor(): void
    {
        $this->sweetAlertBuilder->cancelButtonColor('#6c757d');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['cancelButtonColor' => '#6c757d'], $options);
    }

    public function testDenyButtonAriaLabel(): void
    {
        $this->sweetAlertBuilder->denyButtonAriaLabel('Deny this action');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['denyButtonAriaLabel' => 'Deny this action'], $options);
    }

    public function testCancelButtonAriaLabel(): void
    {
        $this->sweetAlertBuilder->cancelButtonAriaLabel('Cancel this action');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['cancelButtonAriaLabel' => 'Cancel this action'], $options);
    }

    public function testConfirmButtonAriaLabel(): void
    {
        $this->sweetAlertBuilder->confirmButtonAriaLabel('Confirm this action');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['confirmButtonAriaLabel' => 'Confirm this action'], $options);
    }

    public function testConfirmButtonColor(): void
    {
        $this->sweetAlertBuilder->confirmButtonColor('#28a745');

        $envelope = $this->sweetAlertBuilder->getEnvelope();
        $options = $envelope->getNotification()->getOptions();

        $this->assertSame(['confirmButtonColor' => '#28a745'], $options);
    }
}
