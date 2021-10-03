<?php

namespace Flasher\Tests\Symfony\Twig;

use Flasher\Prime\Response\ResponseManagerInterface;
use Flasher\Symfony\Twig\FlasherTwigExtension;
use Flasher\Tests\Prime\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class FlasherTwigExtensionTest extends TestCase
{
    public function testFlasherRenderInstanceOfFunctionExpression()
    {
        $expected = "<script>toastr.success('success title')</script>";

        $responseManager = $this->getMockBuilder('Flasher\Prime\Response\ResponseManagerInterface')->getMock();
        $responseManager->method('render')->willReturn($expected);

        $this->assertEquals($expected, $this->render('{{ flasher_render() }}', $responseManager));
    }

    private function render($template, ResponseManagerInterface $renderer)
    {
        $twig = new Environment(new ArrayLoader(array(
            'template' => $template,
        )), array(
            'debug' => true,
            'cache' => false,
            'autoescape' => 'html',
            'optimizations' => 0,
        ));

        $twig->addExtension(new FlasherTwigExtension($renderer));

        return $twig->render('template');
    }
}
