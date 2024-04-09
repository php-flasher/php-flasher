<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Template;

use Flasher\Laravel\Template\BladeTemplateEngine;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class BladeTemplateEngineTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testRender(): void
    {
        $name = 'test';
        $context = ['key' => 'value'];

        $view = \Mockery::mock(View::class);
        $view->allows('render')->andReturns('rendered data');

        $blade = \Mockery::mock(Factory::class);
        $blade->allows('make')->with($name, $context)->andReturns($view);

        $bladeTemplateEngine = new BladeTemplateEngine($blade);

        $result = $bladeTemplateEngine->render($name, $context);

        $this->assertIsString($result);
        $this->assertSame('rendered data', $result);
    }
}
