<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;
use Flasher\Prime\Envelope;

final class ZenityNotifier extends AbstractNotifier
{
    public function renderEnvelope(Envelope $envelope)
    {
        $cmd = new Command($this->getProgram());

        $cmd
            ->addArgument('--notification')
            ->addOption('--text', $this->getTitle($envelope).'\n\n'.$envelope->getMessage())
            ->addOption('--window-icon', $this->getIcon($envelope));

        $cmd->run();
    }

    public function isSupported()
    {
        return $this->isEnabled() && OS::isUnix() && $this->getProgram();
    }

    public function configureOptions(array $options)
    {
        $default = array(
            'binary' => 'zenity',
            'expire_time' => 0,
            'priority' => 1,
        );

        $options = array_replace_recursive($default, $options);

        parent::configureOptions($options);
    }
}
