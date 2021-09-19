<?php

namespace Flasher\Console\Prime\Notifier;

final class NullNotifier extends AbstractNotifier
{
    public function render(array $envelopes, $firstTime = true)
    {
    }

    public function isSupported()
    {
        return false;
    }
}
