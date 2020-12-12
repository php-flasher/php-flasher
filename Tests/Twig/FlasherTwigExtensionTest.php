<?php

namespace Flasher\Symfony\Tests\Twig;

use Flasher\Prime\Renderer\RendererInterface;
use Flasher\Symfony\Tests\TestCase;
use Flasher\Symfony\Twig\FlasherTwigExtension;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class FlasherTwigExtensionTest extends TestCase
{
    public function testFlasherRenderInstanceOfFunctionExpression()
    {
        $expected = "<script>toastr.success('success title')</script>";

        $renderer = $this->getMockBuilder('Flasher\Prime\Renderer\RendererInterface')->getMock();
        $renderer->method('render')->willReturn($expected);

        $this->assertEquals($expected, $this->render('{{ flasher_render() }}', $renderer));
    }

    private function render($template, RendererInterface $renderer)
    {
        $twig = new Environment(new ArrayLoader(array('template' => $template)), array(
            'debug' => true, 'cache' => false, 'autoescape' => 'html', 'optimizations' => 0,
        ));

        $twig->addExtension(new FlasherTwigExtension($renderer));

        return $twig->render('template');
    }
}
