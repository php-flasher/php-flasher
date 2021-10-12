<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;
use Flasher\Prime\Envelope;

final class TerminalNotifierNotifier extends AbstractNotifier
{
    public function renderEnvelope(Envelope $envelope)
    {
        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('-message', $envelope->getMessage())
            ->addOption('-title', $this->getTitle($envelope));

        if (version_compare(OS::getMacOSVersion(), '10.9.0', '>=')) {
            $cmd->addOption('-appIcon', $this->getIcon($envelope));
        }

        $url = $envelope->getOption('url');
        if ($url) {
            $cmd->addOption('-open', $url);
        }

        $cmd->run();
    }

    public function isSupported()
    {
        return $this->isEnabled() && OS::isMacOS() && $this->getProgram();
    }

    public function configureOptions(array $options)
    {
        $default = array(
            'binary' => 'terminal-notifier',
        );

        $options = array_replace_recursive($default, $options);

        parent::configureOptions($options);
    }
}
