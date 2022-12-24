<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Command;

use Flasher\Symfony\Bridge\Bridge;
use Flasher\Symfony\Support\Bundle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

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
        $output->writeln(sprintf('<bg=blue;options=bold> INFO </> Copying <fg=blue;options=bold>PHPFlasher</> assets into <fg=blue;options=bold>%s</>', $publicDir));
        $output->writeln('');

        $this->filesystem->remove($publicDir);

        $exitCode = 0;

        /** @var KernelInterface $kernel */
        $kernel = $this->getApplication()->getKernel();

        foreach ($kernel->getBundles() as $bundle) {
            if (!$bundle instanceof Bundle) {
                continue;
            }

            $plugin = $bundle->createPlugin();
            $originDir = $plugin->getAssetsDir();

            if (!is_dir($originDir)) {
                continue;
            }

            try {
                $this->filesystem->mkdir($originDir, 0777);
                $this->filesystem->mirror($originDir, $publicDir, Finder::create()->ignoreDotFiles(false)->in($originDir));

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

        /** @var Container $container */
        $container = $this->getApplication()->getKernel()->getContainer();

        if ($container->hasParameter('kernel.project_dir')) {
            $this->projectDir = realpath($container->getParameter('kernel.project_dir')) ?: '';
        } elseif ($container->hasParameter('kernel.root_dir')) {
            $this->projectDir = realpath($container->getParameter('kernel.root_dir').'/../') ?: '';
        }
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

        $publicDir = $this->projectDir.'/'.$targetDir;

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
        if ($targetDir) {
            return $targetDir;
        }

        $defaultPublicDir = Bridge::versionCompare('4', '>=') ? 'public' : 'web';

        if (null === $this->projectDir) {
            return $defaultPublicDir;
        }

        $composerFilePath = $this->projectDir.'/composer.json';

        if (!file_exists($composerFilePath)) {
            return $defaultPublicDir;
        }

        $composerConfig = json_decode(file_get_contents($composerFilePath), true);

        return isset($composerConfig['extra']['public-dir'])
            ? $composerConfig['extra']['public-dir']
            : $defaultPublicDir;
    }
}
