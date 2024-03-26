<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Command;

use Flasher\Tests\Symfony\Fixtures\FlasherKernel;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\Kernel;

final class InstallCommandTest extends MockeryTestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $kernel = new FlasherKernel();
        $kernel->boot();

        $this->configureCommandTester($kernel);
    }

    public function testExecute(): void
    {
        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('PHPFlasher resources have been successfully installed.', $output);
    }

    public function testExecuteWithConfigOption(): void
    {
        $this->commandTester->execute([
            '--config' => true,
        ]);

        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('Configuration files have been published.', $output);
    }

    public function testExecuteWithSymlinkOption(): void
    {
        $this->commandTester->execute([
            '--symlink' => true,
        ]);

        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('Assets were symlinked.', $output);
    }

    public function testExecuteWithAllOptions(): void
    {
        $this->commandTester->execute([
            '--config' => true,
            '--symlink' => true,
        ]);

        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('PHPFlasher resources have been successfully installed.', $output);
        $this->assertStringContainsString('Configuration files have been published.', $output);
        $this->assertStringContainsString('Assets were symlinked.', $output);
    }

    private function configureCommandTester(Kernel $kernel): void
    {
        $application = new Application($kernel);
        $application->setCatchExceptions(false);

        $command = $application->find('flasher:install');
        $this->commandTester = new CommandTester($command);
    }
}
