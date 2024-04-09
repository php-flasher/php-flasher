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
}
