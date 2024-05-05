<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

final class FlasherBuilder extends NotificationBuilder
{
    public function timeout(int $milliseconds): self
    {
        $this->option('timeout', $milliseconds);

        return $this;
    }

    public function direction(string $direction): self
    {
        $this->option('direction', $direction);

        return $this;
    }

    public function position(string $position): self
    {
        $this->option('position', $position);

        return $this;
    }
}
