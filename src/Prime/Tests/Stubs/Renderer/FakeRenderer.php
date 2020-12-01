<?php

namespace Flasher\Prime\Tests\Stubs\Renderer;

use Flasher\Prime\Envelope;
use Flasher\Prime\Renderer\HasGlobalOptionsInterface;
use Flasher\Prime\Renderer\HasScriptsInterface;
use Flasher\Prime\Renderer\HasStylesInterface;
use Flasher\Prime\Renderer\RendererInterface;

class FakeRenderer implements RendererInterface, HasScriptsInterface, HasGlobalOptionsInterface, HasStylesInterface
{
    public function renderOptions()
    {
        return 'fake.options = []';
    }

    public function getScripts()
    {
        return array('jquery.min.js', 'fake.min.js');
    }

    public function getStyles()
    {
        return array('fake.min.css');
    }

    public function render(Envelope $envelope)
    {
        return sprintf(
            "fake.%s('%s', '%s');",
            $envelope->getType(),
            $envelope->getMessage(),
            $envelope->getTitle()
        );
    }
}
