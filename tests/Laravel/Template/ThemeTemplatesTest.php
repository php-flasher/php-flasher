<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Template;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Laravel\TestCase;
use Illuminate\Support\Facades\Blade;

final class ThemeTemplatesTest extends TestCase
{
    private function createEnvelope(string $type, string $message): Envelope
    {
        $notification = new Notification();
        $notification->setType($type);
        $notification->setMessage($message);

        return new Envelope($notification);
    }

    public function testBootstrapTemplateRendersSuccessNotification(): void
    {
        $envelope = $this->createEnvelope('success', 'Success message');

        $html = Blade::render('flasher::bootstrap', ['envelope' => $envelope]);

        $this->assertStringContainsString('alert-success', $html);
        $this->assertStringContainsString('Success message', $html);
        $this->assertStringContainsString('#155724', $html);
    }

    public function testBootstrapTemplateRendersErrorNotification(): void
    {
        $envelope = $this->createEnvelope('error', 'Error message');

        $html = Blade::render('flasher::bootstrap', ['envelope' => $envelope]);

        $this->assertStringContainsString('alert-danger', $html);
        $this->assertStringContainsString('Error message', $html);
        $this->assertStringContainsString('#721c24', $html);
    }

    public function testBootstrapTemplateRendersWarningNotification(): void
    {
        $envelope = $this->createEnvelope('warning', 'Warning message');

        $html = Blade::render('flasher::bootstrap', ['envelope' => $envelope]);

        $this->assertStringContainsString('alert-warning', $html);
        $this->assertStringContainsString('Warning message', $html);
        $this->assertStringContainsString('#856404', $html);
    }

    public function testBootstrapTemplateRendersInfoNotification(): void
    {
        $envelope = $this->createEnvelope('info', 'Info message');

        $html = Blade::render('flasher::bootstrap', ['envelope' => $envelope]);

        $this->assertStringContainsString('alert-info', $html);
        $this->assertStringContainsString('Info message', $html);
        $this->assertStringContainsString('#0c5460', $html);
    }

    public function testTailwindcssTemplateRendersSuccessNotification(): void
    {
        $envelope = $this->createEnvelope('success', 'Success message');

        $html = Blade::render('flasher::tailwindcss', ['envelope' => $envelope]);

        $this->assertStringContainsString('text-green-600', $html);
        $this->assertStringContainsString('bg-green-600', $html);
        $this->assertStringContainsString('border-green-600', $html);
        $this->assertStringContainsString('Success message', $html);
        $this->assertStringContainsString('Success', $html);
    }

    public function testTailwindcssTemplateRendersErrorNotification(): void
    {
        $envelope = $this->createEnvelope('error', 'Error message');

        $html = Blade::render('flasher::tailwindcss', ['envelope' => $envelope]);

        $this->assertStringContainsString('text-red-600', $html);
        $this->assertStringContainsString('bg-red-600', $html);
        $this->assertStringContainsString('border-red-600', $html);
        $this->assertStringContainsString('Error message', $html);
    }

    public function testTailwindcssTemplateRendersWarningNotification(): void
    {
        $envelope = $this->createEnvelope('warning', 'Warning message');

        $html = Blade::render('flasher::tailwindcss', ['envelope' => $envelope]);

        $this->assertStringContainsString('text-yellow-600', $html);
        $this->assertStringContainsString('bg-yellow-600', $html);
        $this->assertStringContainsString('border-yellow-600', $html);
        $this->assertStringContainsString('Warning message', $html);
    }

    public function testTailwindcssTemplateRendersInfoNotification(): void
    {
        $envelope = $this->createEnvelope('info', 'Info message');

        $html = Blade::render('flasher::tailwindcss', ['envelope' => $envelope]);

        $this->assertStringContainsString('text-blue-600', $html);
        $this->assertStringContainsString('bg-blue-600', $html);
        $this->assertStringContainsString('border-blue-600', $html);
        $this->assertStringContainsString('Info message', $html);
    }

    public function testTailwindcssBgTemplateRendersSuccessNotification(): void
    {
        $envelope = $this->createEnvelope('success', 'Success message');

        $html = Blade::render('flasher::tailwindcss_bg', ['envelope' => $envelope]);

        $this->assertStringContainsString('text-green-700', $html);
        $this->assertStringContainsString('bg-green-50', $html);
        $this->assertStringContainsString('border-green-600', $html);
        $this->assertStringContainsString('Success message', $html);
    }

    public function testTailwindcssBgTemplateRendersErrorNotification(): void
    {
        $envelope = $this->createEnvelope('error', 'Error message');

        $html = Blade::render('flasher::tailwindcss_bg', ['envelope' => $envelope]);

        $this->assertStringContainsString('text-red-700', $html);
        $this->assertStringContainsString('bg-red-50', $html);
        $this->assertStringContainsString('border-red-600', $html);
        $this->assertStringContainsString('Error message', $html);
    }

    public function testTailwindcssRTemplateRendersSuccessNotification(): void
    {
        $envelope = $this->createEnvelope('success', 'Success message');

        $html = Blade::render('flasher::tailwindcss_r', ['envelope' => $envelope]);

        $this->assertStringContainsString('text-green-600', $html);
        $this->assertStringContainsString('bg-green-600', $html);
        $this->assertStringContainsString('border-green-600', $html);
        $this->assertStringContainsString('Success message', $html);
    }

    public function testTailwindcssRTemplateRendersErrorNotification(): void
    {
        $envelope = $this->createEnvelope('error', 'Error message');

        $html = Blade::render('flasher::tailwindcss_r', ['envelope' => $envelope]);

        $this->assertStringContainsString('text-red-600', $html);
        $this->assertStringContainsString('bg-red-600', $html);
        $this->assertStringContainsString('border-red-600', $html);
        $this->assertStringContainsString('Error message', $html);
    }

    public function testBootstrapTemplateContainsCloseButton(): void
    {
        $envelope = $this->createEnvelope('success', 'Test');

        $html = Blade::render('flasher::bootstrap', ['envelope' => $envelope]);

        $this->assertStringContainsString('data-dismiss="alert"', $html);
        $this->assertStringContainsString('&times;', $html);
    }

    public function testBootstrapTemplateContainsProgressBar(): void
    {
        $envelope = $this->createEnvelope('success', 'Test');

        $html = Blade::render('flasher::bootstrap', ['envelope' => $envelope]);

        $this->assertStringContainsString('flasher-progress', $html);
    }

    public function testTailwindcssTemplatesContainProgressBar(): void
    {
        $envelope = $this->createEnvelope('success', 'Test');

        $html1 = Blade::render('flasher::tailwindcss', ['envelope' => $envelope]);
        $html2 = Blade::render('flasher::tailwindcss_bg', ['envelope' => $envelope]);
        $html3 = Blade::render('flasher::tailwindcss_r', ['envelope' => $envelope]);

        $this->assertStringContainsString('flasher-progress', $html1);
        $this->assertStringContainsString('flasher-progress', $html2);
        $this->assertStringContainsString('flasher-progress', $html3);
    }

    public function testTemplatesContainIcons(): void
    {
        $envelope = $this->createEnvelope('success', 'Test');

        $html1 = Blade::render('flasher::tailwindcss', ['envelope' => $envelope]);
        $html2 = Blade::render('flasher::tailwindcss_bg', ['envelope' => $envelope]);
        $html3 = Blade::render('flasher::tailwindcss_r', ['envelope' => $envelope]);

        $this->assertStringContainsString('<svg', $html1);
        $this->assertStringContainsString('<svg', $html2);
        $this->assertStringContainsString('<svg', $html3);
    }

    public function testUnknownTypeDefaultsToInfo(): void
    {
        $envelope = $this->createEnvelope('custom', 'Unknown type');

        $htmlBootstrap = Blade::render('flasher::bootstrap', ['envelope' => $envelope]);
        $htmlTailwind = Blade::render('flasher::tailwindcss', ['envelope' => $envelope]);

        $this->assertStringContainsString('alert-info', $htmlBootstrap);
        $this->assertStringContainsString('#0c5460', $htmlBootstrap);
        $this->assertStringContainsString('text-blue-600', $htmlTailwind);
        $this->assertStringContainsString('bg-blue-600', $htmlTailwind);
    }

    public function testTemplatesEscapeHtmlInMessage(): void
    {
        $envelope = $this->createEnvelope('success', '<script>alert("xss")</script>');

        $html = Blade::render('flasher::bootstrap', ['envelope' => $envelope]);

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringContainsString('&lt;script&gt;', $html);
    }

    public function testAllTemplatesExist(): void
    {
        // @phpstan-ignore-next-line
        $this->assertTrue(view()->exists('flasher::bootstrap'));
        // @phpstan-ignore-next-line
        $this->assertTrue(view()->exists('flasher::tailwindcss'));
        // @phpstan-ignore-next-line
        $this->assertTrue(view()->exists('flasher::tailwindcss_bg'));
        // @phpstan-ignore-next-line
        $this->assertTrue(view()->exists('flasher::tailwindcss_r'));
    }
}
