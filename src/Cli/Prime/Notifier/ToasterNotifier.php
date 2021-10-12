<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;
use Flasher\Cli\Prime\System\Path;
use Flasher\Prime\Envelope;

final class ToasterNotifier extends AbstractNotifier
{
    public function renderEnvelope(Envelope $envelope)
    {
        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('-t', $this->getTitle($envelope))
            ->addOption('-m', $envelope->getMessage())
            ->addOption('-p', $this->getIcon($envelope))
            ->addArgument('-w');;

        $cmd->run();
    }

    public function isSupported()
    {
        if (!$this->getProgram() || !$this->isEnabled()) {
            return false;
        }

        return OS::isWindowsEightOrHigher() || OS::isWindowsSubsystemForLinux();
    }

    public function configureOptions(array $options)
    {
        $default = array(
            'binary' => 'toast',
            'binary_paths' => array(
                Path::realpath(__DIR__.'/../Resources/bin/toaster/toast.exe'),
            ),
        );

        $options = array_replace_recursive($default, $options);

        parent::configureOptions($options);
    }
}
