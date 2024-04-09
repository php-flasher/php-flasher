<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Template;

use Flasher\Symfony\Template\TwigTemplateEngine;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

final class TwigTemplateEngineTest extends TestCase
{
    /**
     * This test case covers the `render` method of the `TwigTemplateEngine` class.
     * For a successful operation, a valid Twig environment is required.
     */
    public function testRenderOutputsExpectedStringWithValidTwigEnvironment(): void
    {
        $loader = new ArrayLoader(['templateName' => 'Hello {{ name }}!']);

        $twig = new Environment($loader);

        $templateEngine = new TwigTemplateEngine($twig);

        $actual = $templateEngine->render('templateName', ['name' => 'John Doe']);

        $this->assertSame('Hello John Doe!', $actual);
    }

    /**
     * This test case covers the `render` method of the `TwigTemplateEngine` class.
     * If Twig environment is null, a LogicException should be thrown.
     */
    public function testRenderThrowsLogicExceptionWithNullTwigEnvironment(): void
    {
        $this->expectException(\LogicException::class);

        $templateEngineWithoutTwig = new TwigTemplateEngine(null);

        $templateEngineWithoutTwig->render('templateName', ['name' => 'John Doe']);
    }
}
