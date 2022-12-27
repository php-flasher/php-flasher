<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Command;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('flasher:install')
            ->setDescription('Install all of the PHPFlasher resources.')
            ->addArgument('target', InputArgument::OPTIONAL, 'The target directory')
        ;
    }

    /**
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $publicDir = $this->getPublicDirectory($input);
        $publicDir = rtrim($publicDir, '/').'/vendor/flasher/';

        $output->writeln('');
        $output->writeln('<fg=blue;options=bold>
            ██████╗ ██╗  ██╗██████╗ ███████╗██╗      █████╗ ███████╗██╗  ██╗███████╗██████╗
            ██╔══██╗██║  ██║██╔══██╗██╔════╝██║     ██╔══██╗██╔════╝██║  ██║██╔════╝██╔══██╗
            ██████╔╝███████║██████╔╝█████╗  ██║     ███████║███████╗███████║█████╗  ██████╔╝
            ██╔═══╝ ██╔══██║██╔═══╝ ██╔══╝  ██║     ██╔══██║╚════██║██╔══██║██╔══╝  ██╔══██╗
            ██║     ██║  ██║██║     ██║     ███████╗██║  ██║███████║██║  ██║███████╗██║  ██║
            ╚═╝     ╚═╝  ╚═╝╚═╝     ╚═╝     ╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
        </>');
        $output->writeln('');

        $output->writeln('');
        $output->writeln(sprintf('<bg=blue;options=bold> INFO </> Copying <fg=blue;options=bold>PHPFlasher</> assets into <fg=blue;options=bold>%s</>', $publicDir));
        $output->writeln('');

        $this->filesystem->cleanDirectory($publicDir);

        $exitCode = 0;

        foreach (ServiceProvider::publishableProviders() as $provider) {
            if (!is_a($provider, 'Flasher\Laravel\Support\ServiceProvider', true)) {
                continue;
            }

            /** @var \Flasher\Laravel\Support\ServiceProvider $provider */
            $provider = App::getProvider($provider);

            $plugin = $provider->createPlugin();
            $originDir = $plugin->getAssetsDir();

            if (!is_dir($originDir)) {
                continue;
            }

            try {
                $this->filesystem->ensureDirectoryExists($originDir, 0777);
                $this->filesystem->copyDirectory($originDir, $publicDir);

                $status = sprintf('<fg=green;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'OK' : "\xE2\x9C\x94" /* HEAVY CHECK MARK (U+2714) */);
                $output->writeln(sprintf(' %s <fg=blue;options=bold>%s</>', $status, $plugin->getAlias()));
            } catch (\Exception $e) {
                $exitCode = 1;
                $status = sprintf('<fg=red;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'ERROR' : "\xE2\x9C\x98" /* HEAVY BALLOT X (U+2718) */);
                $output->writeln(sprintf(' %s <fg=blue;options=bold>%s</> <error>%s</error>', $status, $plugin->getAlias(), $e->getMessage()));
            }
        }

        $output->writeln('');

        return $exitCode;
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->filesystem = new Filesystem();
        $this->projectDir = App::basePath();
    }

    /**
     * @return string
     */
    private function getPublicDirectory(InputInterface $input)
    {
        $targetDir = $this->getTargetDirectory($input);
        if (is_dir($targetDir)) {
            return $targetDir;
        }

        $publicDir = App::basePath().'/'.$targetDir;
        if (is_dir($publicDir)) {
            return $publicDir;
        }

        throw new \InvalidArgumentException(sprintf('The target directory "%s" does not exist.', $publicDir));
    }

    /**
     * @return string
     */
    private function getTargetDirectory(InputInterface $input)
    {
        $targetDir = rtrim($input->getArgument('target') ?: '', '/');

        return $targetDir ?: App::publicPath();
    }
}
