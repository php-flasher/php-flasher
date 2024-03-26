<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Template;

use Flasher\Prime\Template\PHPTemplateEngine;
use PHPUnit\Framework\TestCase;

final class PHPTemplateEngineTest extends TestCase
{
    private PHPTemplateEngine $templateEngine;

    protected function setUp(): void
    {
        $this->templateEngine = new PHPTemplateEngine();
    }

    /**
     * Test case for testing the render method with a valid filename and context.
     */
    public function testRenderWithValidFilenameContext(): void
    {
        $name = 'someTemplateFile.php';
        $context = ['key' => 'value'];

        // Create a fake template file for the purpose of this test.
        file_put_contents($name, '<?php echo $key;');

        $result = $this->templateEngine->render($name, $context);

        // Cleanup the fake template file
        unlink($name);

        $this->assertSame('value', trim($result), "Rendered template content doesn't match expected content.");
    }

    /**
     * Test case for testing the render method with an invalid filename.
     */
    public function testRenderWithInvalidFilename(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->templateEngine->render('invalidFileName.php');
    }
}
