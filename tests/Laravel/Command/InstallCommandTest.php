<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Command;

use Flasher\Tests\Laravel\TestCase;

final class InstallCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $this->artisan('flasher:install')
            ->assertExitCode(0);
    }

    public function testExecuteWithConfigOption(): void
    {
        $this->artisan('flasher:install', ['--config' => true])
            ->assertExitCode(0);
    }

    public function testExecuteWithSymlinkOption(): void
    {
        $this->artisan('flasher:install', ['--symlink' => true])
            ->assertExitCode(0);
    }

    public function testExecuteWithAllOptions(): void
    {
        $this->artisan('flasher:install', ['--config' => true, '--symlink' => true])
            ->assertExitCode(0);
    }
}
