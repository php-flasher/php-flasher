<?php

namespace Flasher\Console\Prime\Notifier;

use Flasher\Prime\Envelope;

final class NotifySendNotifier extends AbstractNotifier
{
    public function render(array $envelopes, $firstTime = true)
    {
        if ($firstTime) {
            $this->playSound();
        }

        foreach ($envelopes as $envelope) {
            $this->renderEnvelope($envelope);
        }
    }

    public function renderEnvelope(Envelope $envelope)
    {
        $cmd = $this->getBinary();

        $cmd .= ' --urgency="normal"';
        $cmd .= ' --app-name="notify"';
        $cmd .= ' --icon="'.$this->getIcon($envelope->getType()).'"';
        $cmd .= ' --expire-time=' . $this->getExpireTime();
        $cmd .= ' "' . $this->getTitle() . '"';
        $cmd .= ' "' . addslashes($envelope->getMessage()) . '"';

        \exec($cmd);
    }

    public function isSupported()
    {
        return $this->isEnabled() && in_array(PHP_OS, array(
            'Linux',
            'FreeBSD',
            'NetBSD',
            'OpenBSD',
            'SunOS',
            'DragonFly',
        ));
    }

    public function getExpireTime()
    {
        return (int) $this->options['expire_time'];
    }

    public function configureOptions(array $options)
    {
        $default = array(
            'binary' => 'notify-send',
            'expire_time' => 0,
        );

        $options = array_replace($default, $options);

        parent::configureOptions($options);
    }
}
