<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Component;

use Flasher\Laravel\Component\FlasherComponent;
use Flasher\Prime\FlasherInterface;
use Illuminate\Container\Container;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * FlasherComponentTest tests the render method in the FlasherComponent class.
 */
final class FlasherComponentTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private FlasherComponent $flasherComponent;

    protected function setUp(): void
    {
        parent::setUp();

        $flasherServiceMock = \Mockery::mock(FlasherInterface::class);
        $flasherServiceMock->allows('render')
                           ->andReturns('Your expected result');

        Container::getInstance()->instance('flasher', $flasherServiceMock);

        $this->flasherComponent = new FlasherComponent('{"key":"value"}', '{"key":"value"}');
    }

    public function testRender(): void
    {
        $expectedResult = 'Your expected result';
        $actualResult = $this->flasherComponent->render();
        $this->assertSame($expectedResult, $actualResult);
    }

    public function testRenderWithInvalidJsonCriteriaDoesNotThrow(): void
    {
        // Invalid JSON should not throw exception - should gracefully return empty array
        $component = new FlasherComponent('{"invalid json', '{}');

        // Should not throw JsonException
        $result = $component->render();

        $this->assertSame('Your expected result', $result);
    }

    public function testRenderWithInvalidJsonContextDoesNotThrow(): void
    {
        // Invalid JSON should not throw exception - should gracefully return empty array
        $component = new FlasherComponent('{}', '{"invalid json');

        // Should not throw JsonException
        $result = $component->render();

        $this->assertSame('Your expected result', $result);
    }

    public function testRenderWithEmptyStringsDoesNotThrow(): void
    {
        // Empty strings should be handled gracefully
        $component = new FlasherComponent('', '');

        // Should not throw JsonException
        $result = $component->render();

        $this->assertSame('Your expected result', $result);
    }

    public function testRenderWithNonArrayJsonReturnsEmptyArray(): void
    {
        // Non-array JSON values should return empty array
        $component = new FlasherComponent('"just a string"', '123');

        // Should not throw and should use empty arrays
        $result = $component->render();

        $this->assertSame('Your expected result', $result);
    }
}
