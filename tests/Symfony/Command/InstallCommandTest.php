<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Command;

use Flasher\Tests\Symfony\Fixtures\FlasherKernel;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\Kernel;

final class InstallCommandTest extends MockeryTestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        parent::setUp();

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

    public function testExecuteFailsGracefullyWhenPublicDirIsNull(): void
    {
        // Create a kernel that returns a non-existent project directory
        // This will cause getPublicDir() to return null
        $kernel = new class() extends Kernel {
            public function __construct()
            {
                parent::__construct('test', true);
            }

            public function registerBundles(): iterable
            {
                return [
                    new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
                    new \Flasher\Symfony\FlasherSymfonyBundle(),
                ];
            }

            public function registerContainerConfiguration(\Symfony\Component\Config\Loader\LoaderInterface $loader): void
            {
                $loader->load(function (\Symfony\Component\DependencyInjection\ContainerBuilder $container): void {
                    $container->register('kernel', static::class)->setPublic(true);
                    $container->loadFromExtension('framework', [
                        'secret' => 'test',
                        'test' => true,
                        'session' => [
                            'handler_id' => null,
                            'storage_factory_id' => 'session.storage.factory.mock_file',
                        ],
                    ]);
                });
            }

            public function getProjectDir(): string
            {
                // Return a non-existent directory without public/ subfolder
                return '/non-existent-directory-'.uniqid();
            }

            public function getCacheDir(): string
            {
                return sys_get_temp_dir().'/cache'.spl_object_hash($this);
            }

            public function getLogDir(): string
            {
                return sys_get_temp_dir().'/logs'.spl_object_hash($this);
            }
        };

        $kernel->boot();

        $application = new Application($kernel);
        $application->setCatchExceptions(false);

        $commandTester = new CommandTester($application->find('flasher:install'));
        $exitCode = $commandTester->execute([]);

        $output = $commandTester->getDisplay();

        // Should fail gracefully with an error message instead of crashing
        $this->assertSame(Command::FAILURE, $exitCode);
        $this->assertStringContainsString('Could not determine the public directory', $output);
    }
}
