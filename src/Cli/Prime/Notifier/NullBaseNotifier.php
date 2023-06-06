<?php

namespace Flasher\Cli\Prime\Notifier;

final class NullBaseNotifier extends BaseNotifier
{
    public function send($notification)
    {
    }

    public function isSupported()
    {
        return false;
    }

    public function getBinary()
    {
        return '';
    }
}
