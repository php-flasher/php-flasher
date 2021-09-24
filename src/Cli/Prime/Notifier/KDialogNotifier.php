<?php

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\System\Command;
use Flasher\Cli\Prime\System\OS;
use Flasher\Prime\Envelope;

final class KDialogNotifier extends AbstractNotifier
{
    public function renderEnvelope(Envelope $envelope)
    {
        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('--passivepopup', $envelope->getMessage())
            ->addOption('--title', $this->getTitle($envelope))
            ->addArgument(5)
        ;

        $cmd->run();
    }

    public function isSupported()
    {
        return $this->isEnabled() && OS::isUnix() && $this->getProgram();
    }

    public function configureOptions(array $options)
    {
        $default = array(
            'binary' => 'kdialog',
        );

        $options = array_replace($default, $options);

        parent::configureOptions($options);
    }
}
