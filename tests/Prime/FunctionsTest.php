<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Factory\NotificationFactoryLocatorInterface;
use Flasher\Prime\Flasher;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Type;
use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

use function Flasher\Prime\flash as namespacedFlash;

final class FunctionsTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private FlasherInterface $flasher;

    protected function setUp(): void
    {
        parent::setUp();

        $factoryLocator = \Mockery::mock(NotificationFactoryLocatorInterface::class);
        $responseManager = \Mockery::mock(ResponseManagerInterface::class);
        $storageManager = \Mockery::mock(StorageManagerInterface::class);

        $storageManager->allows('add')->andReturnUsing(fn ($envelope) => $envelope);

        $this->flasher = new Flasher('flasher', $factoryLocator, $responseManager, $storageManager);

        FlasherContainer::reset();
        FlasherContainer::setContainer($this->flasher);
    }

    protected function tearDown(): void
    {
        FlasherContainer::reset();

        parent::tearDown();
    }

    public function testFlashWithNoArgumentsReturnsFlasherInterface(): void
    {
        $result = namespacedFlash();

        $this->assertInstanceOf(FlasherInterface::class, $result);
    }

    public function testFlashWithMessageReturnsEnvelope(): void
    {
        $result = namespacedFlash('Hello World');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('Hello World', $result->getMessage());
        $this->assertSame(Type::SUCCESS, $result->getType());
    }

    public function testFlashWithAllArgumentsReturnsEnvelope(): void
    {
        $result = namespacedFlash(
            'Operation completed',
            Type::INFO,
            ['timeout' => 5000],
            'Custom Title'
        );

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('Operation completed', $result->getMessage());
        $this->assertSame(Type::INFO, $result->getType());
        $this->assertSame('Custom Title', $result->getTitle());
        $this->assertSame(5000, $result->getOption('timeout'));
    }

    public function testFlashWithDifferentTypes(): void
    {
        $successResult = namespacedFlash('Success message', Type::SUCCESS);
        $this->assertSame(Type::SUCCESS, $successResult->getType());

        $errorResult = namespacedFlash('Error message', Type::ERROR);
        $this->assertSame(Type::ERROR, $errorResult->getType());

        $warningResult = namespacedFlash('Warning message', Type::WARNING);
        $this->assertSame(Type::WARNING, $warningResult->getType());

        $infoResult = namespacedFlash('Info message', Type::INFO);
        $this->assertSame(Type::INFO, $infoResult->getType());
    }

    public function testFlashWithOptions(): void
    {
        $options = [
            'timeout' => 3000,
            'position' => 'top-right',
            'closeButton' => true,
        ];

        $result = namespacedFlash('Test message', Type::SUCCESS, $options);

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame(3000, $result->getOption('timeout'));
        $this->assertSame('top-right', $result->getOption('position'));
        $this->assertTrue($result->getOption('closeButton'));
    }

    public function testFlashWithTitle(): void
    {
        $result = namespacedFlash('Message body', Type::SUCCESS, [], 'Notification Title');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('Notification Title', $result->getTitle());
        $this->assertSame('Message body', $result->getMessage());
    }

    public function testNamespacedFlashFunction(): void
    {
        // Test that the namespaced function exists and works
        $this->assertTrue(\function_exists('Flasher\Prime\flash'));

        $result = namespacedFlash();
        $this->assertInstanceOf(FlasherInterface::class, $result);

        $envelope = namespacedFlash('Test message');
        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testGlobalFlashFunction(): void
    {
        // Ensure the global function exists
        $this->assertTrue(\function_exists('flash'));

        $result = flash();
        $this->assertInstanceOf(FlasherInterface::class, $result);

        $envelope = flash('Test message');
        $this->assertInstanceOf(Envelope::class, $envelope);
    }

    public function testBothFunctionsReturnSameResult(): void
    {
        // Both functions should use the same container and return equivalent results
        $namespacedResult = namespacedFlash();
        $globalResult = flash();

        // Both should return the same FlasherInterface instance
        $this->assertInstanceOf(FlasherInterface::class, $namespacedResult);
        $this->assertInstanceOf(FlasherInterface::class, $globalResult);

        // Create notifications with both functions
        $namespacedEnvelope = namespacedFlash('Test message', Type::SUCCESS);
        $globalEnvelope = flash('Test message', Type::SUCCESS);

        // Both should produce Envelopes with the same structure
        $this->assertInstanceOf(Envelope::class, $namespacedEnvelope);
        $this->assertInstanceOf(Envelope::class, $globalEnvelope);
        $this->assertSame('Test message', $namespacedEnvelope->getMessage());
        $this->assertSame('Test message', $globalEnvelope->getMessage());
        $this->assertSame(Type::SUCCESS, $namespacedEnvelope->getType());
        $this->assertSame(Type::SUCCESS, $globalEnvelope->getType());
    }

    public function testFlashWithEmptyMessage(): void
    {
        $result = namespacedFlash('');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame('', $result->getMessage());
    }

    public function testFlashWithNullMessage(): void
    {
        // When message is null and func_num_args is 0, returns FlasherInterface
        // When message is explicitly null but args > 0, should still flash
        $result = namespacedFlash(null);

        // Based on the function signature, passing null should trigger the envelope creation
        $this->assertInstanceOf(Envelope::class, $result);
    }

    public function testFlashWithUnicodeMessage(): void
    {
        $unicodeMessage = 'Hello';

        $result = namespacedFlash($unicodeMessage, Type::INFO, [], 'Title');

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame($unicodeMessage, $result->getMessage());
        $this->assertSame('Title', $result->getTitle());
    }

    public function testFlashWithSpecialCharactersInMessage(): void
    {
        $specialMessage = '<script>alert("XSS")</script> & "quotes" \'single\'';

        $result = namespacedFlash($specialMessage);

        $this->assertInstanceOf(Envelope::class, $result);
        $this->assertSame($specialMessage, $result->getMessage());
    }

    public function testFlashWithEmptyOptions(): void
    {
        $result = namespacedFlash('Message', Type::SUCCESS, []);

        $this->assertInstanceOf(Envelope::class, $result);
        // Options should be empty or have default values
        $options = $result->getOptions();
        $this->assertIsArray($options);
    }

    public function testFlashWithNullTitle(): void
    {
        $result = namespacedFlash('Message', Type::ERROR, [], null);

        $this->assertInstanceOf(Envelope::class, $result);
        // Title should be empty string when null is passed
        $this->assertSame('', $result->getTitle());
    }

    public function testFlashChainability(): void
    {
        // When called without arguments, should return FlasherInterface
        // which can be used for chaining
        $flasher = namespacedFlash();

        $this->assertInstanceOf(FlasherInterface::class, $flasher);

        // Should be able to use the flasher methods
        $envelope = $flasher->success('Success message');
        $this->assertInstanceOf(Envelope::class, $envelope);
    }
}
