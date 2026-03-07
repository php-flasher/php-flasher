<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Http;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\RequestExtension;
use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class RequestExtensionTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&FlasherInterface $flasher;

    private MockInterface&RequestInterface $request;

    private MockInterface&ResponseInterface $response;

    /** @var array<string, string[]> */
    private array $mapping = [
        'success' => ['happy', 'joy'],
        'error' => ['sad', 'oops'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->flasher = \Mockery::mock(FlasherInterface::class);
        $this->request = \Mockery::mock(RequestInterface::class);
        $this->response = \Mockery::mock(ResponseInterface::class);
    }

    public function testFlashWithoutSession(): void
    {
        $this->request->expects()->hasSession()->andReturns(false);

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $response = $extension->flash($this->request, $this->response);

        $this->assertSame($this->response, $response, 'Response should be returned unchanged if request has no session.');
    }

    public function testFlashWithSessionAndMessages(): void
    {
        $this->request->expects()->hasSession()->andReturns(true);
        $this->request->allows('hasType')->andReturnUsing(fn ($type) => 'happy' === $type);
        $this->request->allows('getType')->andReturnUsing(fn ($type) => 'happy' === $type ? ['Good job!'] : []);

        $this->flasher->expects()->flash('success', 'Good job!');
        $this->request->expects()->forgetType('happy')->once();

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $extension->flash($this->request, $this->response);
    }

    public function testProcessRequestIgnoresUnmappedTypes(): void
    {
        $this->request->expects()->hasSession()->andReturns(true);
        $this->request->allows('hasType')->andReturnUsing(fn ($type) => 'unmappedType' === $type);

        $this->flasher->expects()->flash()->never();
        $this->request->expects()->forgetType('unmappedType')->never();

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $extension->flash($this->request, $this->response);
    }

    public function testConstructorFlattensMappingCorrectly(): void
    {
        $extension = new RequestExtension($this->flasher, $this->mapping);

        $reflectedClass = new \ReflectionClass($extension);
        $flatMappingProperty = $reflectedClass->getProperty('mapping');

        $expectedFlatMapping = [
            'happy' => 'success',
            'joy' => 'success',
            'sad' => 'error',
            'oops' => 'error',
        ];

        $this->assertSame($expectedFlatMapping, $flatMappingProperty->getValue($extension), 'Mapping should be flattened correctly.');
    }

    public function testProcessMultipleMessagesInSingleBag(): void
    {
        $messages = ['First message', 'Second message', 'Third message'];

        $this->request->expects()->hasSession()->andReturns(true);
        $this->request->allows('hasType')->andReturnUsing(fn ($type) => 'happy' === $type);
        $this->request->allows('getType')->andReturnUsing(fn ($type) => 'happy' === $type ? $messages : []);

        // Should flash all three messages
        $this->flasher->expects()->flash('success', 'First message')->once();
        $this->flasher->expects()->flash('success', 'Second message')->once();
        $this->flasher->expects()->flash('success', 'Third message')->once();
        $this->request->expects()->forgetType('happy')->once();

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $extension->flash($this->request, $this->response);
    }

    public function testProcessMessagesWithSpecialCharacters(): void
    {
        $specialMessage = '<script>alert("XSS")</script> & "quotes" \'single\' < > &amp;';

        $this->request->expects()->hasSession()->andReturns(true);
        $this->request->allows('hasType')->andReturnUsing(fn ($type) => 'happy' === $type);
        $this->request->allows('getType')->andReturnUsing(fn ($type) => 'happy' === $type ? [$specialMessage] : []);

        $this->flasher->expects()->flash('success', $specialMessage)->once();
        $this->request->expects()->forgetType('happy')->once();

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $extension->flash($this->request, $this->response);
    }

    public function testProcessMessagesWithUnicodeContent(): void
    {
        $unicodeMessages = [
            'Hello',
            'Bonjour',
            'Hola',
        ];

        $this->request->expects()->hasSession()->andReturns(true);
        $this->request->allows('hasType')->andReturnUsing(fn ($type) => 'happy' === $type);
        $this->request->allows('getType')->andReturnUsing(fn ($type) => 'happy' === $type ? $unicodeMessages : []);

        foreach ($unicodeMessages as $message) {
            $this->flasher->expects()->flash('success', $message)->once();
        }
        $this->request->expects()->forgetType('happy')->once();

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $extension->flash($this->request, $this->response);
    }

    public function testProcessEmptyMessageValue(): void
    {
        $this->request->expects()->hasSession()->andReturns(true);
        $this->request->allows('hasType')->andReturnUsing(fn ($type) => 'happy' === $type);
        $this->request->allows('getType')->andReturnUsing(fn ($type) => 'happy' === $type ? [''] : []);

        // Empty string message should still be flashed
        $this->flasher->expects()->flash('success', '')->once();
        $this->request->expects()->forgetType('happy')->once();

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $extension->flash($this->request, $this->response);
    }

    public function testProcessNullMessageValue(): void
    {
        $this->request->expects()->hasSession()->andReturns(true);
        $this->request->allows('hasType')->andReturnUsing(fn ($type) => 'happy' === $type);
        $this->request->allows('getType')->andReturnUsing(fn ($type) => 'happy' === $type ? [null] : []);

        // Null values in the messages array should be passed through
        $this->flasher->expects()->flash('success', null)->once();
        $this->request->expects()->forgetType('happy')->once();

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $extension->flash($this->request, $this->response);
    }

    public function testProcessMixedMessageTypes(): void
    {
        // Messages can include strings, nulls, and empty strings
        $mixedMessages = ['Valid message', '', 'Another valid message'];

        $this->request->expects()->hasSession()->andReturns(true);
        $this->request->allows('hasType')->andReturnUsing(fn ($type) => 'happy' === $type);
        $this->request->allows('getType')->andReturnUsing(fn ($type) => 'happy' === $type ? $mixedMessages : []);

        $this->flasher->expects()->flash('success', 'Valid message')->once();
        $this->flasher->expects()->flash('success', '')->once();
        $this->flasher->expects()->flash('success', 'Another valid message')->once();
        $this->request->expects()->forgetType('happy')->once();

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $extension->flash($this->request, $this->response);
    }

    public function testProcessStringMessageAsArray(): void
    {
        // getType can return a string which gets cast to array
        $this->request->expects()->hasSession()->andReturns(true);
        $this->request->allows('hasType')->andReturnUsing(fn ($type) => 'happy' === $type);
        $this->request->allows('getType')->andReturnUsing(fn ($type) => 'happy' === $type ? 'Single string message' : []);

        $this->flasher->expects()->flash('success', 'Single string message')->once();
        $this->request->expects()->forgetType('happy')->once();

        $extension = new RequestExtension($this->flasher, $this->mapping);
        $extension->flash($this->request, $this->response);
    }
}
