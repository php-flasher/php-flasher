<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;
use Flasher\Prime\Envelope;

final class AppleScriptNotifier extends AbstractNotifier
{
    public function renderEnvelope(Envelope $envelope)
    {
        $cmd = new Command($this->getProgram());

        $cmd
            ->addArgument(sprintf('display notification "%s"', $envelope->getMessage()))
            ->addArgument(sprintf('with title "%s"', $this->getTitle($envelope)));

        $subtitle = $envelope->getOption('subtitle');
        if ($subtitle) {
            $cmd->addArgument(sprintf('subtitle "%s"', $subtitle));
        }

        $sound = $envelope->getOption('sound');
        if ($sound) {
            $cmd->addArgument(sprintf('sound name "%s"', $sound));
        }

        $cmd->run();
    }

    public function isSupported()
    {
        if (!$this->getProgram() || !$this->isEnabled()) {
            return false;
        }

        return OS::isMacOS() && version_compare(OS::getMacOSVersion(), '10.9.0', '>=');
    }

    public function configureOptions(array $options)
    {
        $default = array(
            'binary' => 'osascript',
        );

        $options = array_replace_recursive($default, $options);

        parent::configureOptions($options);
    }
}
