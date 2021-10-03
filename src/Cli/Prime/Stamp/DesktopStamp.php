<?php

namespace Flasher\Cli\Prime\Stamp;

use Flasher\Prime\Stamp\StampInterface;

final class DesktopStamp implements StampInterface
{
    /** @var bool */
    private $renderImmediately;

    public function __construct($renderImmediately = true)
    {
        $this->renderImmediately = $renderImmediately;
    }

    /**
     * @return bool
     */
    public function isRenderImmediately()
    {
        return $this->renderImmediately;
    }
}
