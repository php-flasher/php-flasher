<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Command;

use Flasher\Tests\Laravel\TestCase;
use Illuminate\Support\Facades\Artisan;

final class InstallCommandTest extends TestCase
{
    public function testExecute(): void
    {
        Artisan::call('flasher:install');

        $output = Artisan::output();

        $this->assertStringContainsString('PHPFlasher resources have been successfully installed.', $output);
    }

    public function testExecuteWithConfigOption(): void
    {
        Artisan::call('flasher:install', ['--config' => true]);

        $output = Artisan::output();

        $this->assertStringContainsString('Configuration files have been published.', $output);
    }

    public function testExecuteWithSymlinkOption(): void
    {
        Artisan::call('flasher:install', ['--symlink' => true]);

        $output = Artisan::output();

        $this->assertStringContainsString('Assets were symlinked.', $output);
    }

    public function testExecuteWithAllOptions(): void
    {
        Artisan::call('flasher:install', ['--config' => true, '--symlink' => true]);

        $output = Artisan::output();

        $this->assertStringContainsString('PHPFlasher resources have been successfully installed.', $output);
        $this->assertStringContainsString('Configuration files have been published.', $output);
        $this->assertStringContainsString('Assets were symlinked.', $output);
    }
}
