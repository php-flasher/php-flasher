<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Twig;

use Flasher\Prime\FlasherInterface;
use Flasher\Symfony\Twig\FlasherTwigExtension;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Twig\TwigFunction;

/**
 * Test case for the FlasherTwigExtension class.
 * The class is responsible for providing twig functions to flasher.
 */
final class FlasherTwigExtensionTest extends MockeryTestCase
{
    private MockInterface&FlasherInterface $flasher;
    private FlasherTwigExtension $extension;

    protected function setUp(): void
    {
        $this->flasher = \Mockery::mock(FlasherInterface::class);
        $this->extension = new FlasherTwigExtension($this->flasher);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
    }

    /**
     * Tests the getFunctions method.
     * Ensures the method returns an array of TwigFunction instances.
     */
    public function testGetFunctions(): void
    {
        $functions = $this->extension->getFunctions();

        $this->assertIsArray($functions);
        $this->assertCount(1, $functions);
        $this->assertInstanceOf(TwigFunction::class, $functions[0]);
        $this->assertSame('flasher_render', $functions[0]->getName());
    }

    /**
     * Tests the render method when called without any criteria, presenter or context.
     * Ensures the render method forwards the call to the FlasherInterface's render method with default arguments.
     */
    public function testRenderWithoutArguments(): void
    {
        $this->flasher->expects()
            ->render('html', [], [])
            ->once()
            ->andReturn('Rendered content');

        $result = $this->extension->render();
        $this->assertSame('Rendered content', $result);
    }

    /**
     * Tests the render method when called with specific criteria, presenter and context.
     * Ensures the render method forwards the call to the FlasherInterface's render method with the provided arguments.
     */
    public function testRenderWithArguments(): void
    {
        $criteria = ['type' => 'info'];
        $presenter = 'json';
        $context = ['option' => 'value'];

        $this->flasher->expects()
            ->render($presenter, $criteria, $context)
            ->once()
            ->andReturn('Rendered content');

        $result = $this->extension->render($criteria, $presenter, $context);
        $this->assertSame('Rendered content', $result);
    }
}
