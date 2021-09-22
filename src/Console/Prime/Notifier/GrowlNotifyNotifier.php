<?php

namespace Flasher\Console\Prime\Notifier;

use Flasher\Console\Prime\System\Command;
use Flasher\Console\Prime\System\OS;
use Flasher\Prime\Envelope;

final class GrowlNotifyNotifier extends AbstractNotifier
{
    public function renderEnvelope(Envelope $envelope)
    {
        $cmd = new Command($this->getProgram());

        $cmd
            ->addOption('--message', $envelope->getMessage())
            ->addOption('--title', $this->getTitle())
            ->addOption('--image', $this->getIcon($envelope->getType()))
        ;

        $cmd->run();
    }

    public function isSupported()
    {
        return $this->isEnabled() && OS::isMacOS() && $this->getProgram();
    }

    public function configureOptions(array $options)
    {
        $default = array(
            'binary' => 'growlnotify',
        );

        $options = array_replace($default, $options);

        parent::configureOptions($options);
    }
}
