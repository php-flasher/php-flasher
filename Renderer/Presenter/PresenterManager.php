<?php

namespace Flasher\Prime\Renderer\Presenter;

use Flasher\Prime\Config\ConfigInterface;

final class PresenterManager implements PresenterManagerInterface
{
    /**
     * @var array<string, PresenterInterface>
     */
    private $presenters;

    public function __construct(ConfigInterface $config)
    {
        $this->addPresenter('array', new ArrayPresenter($config));
        $this->addPresenter('html', new HtmlPresenter($config));
    }

    /**
     * @inheritDoc
     */
    public function addPresenter($alias, PresenterInterface $response)
    {
        $this->presenters[$alias] = $response;
    }

    /**
     * @inheritDoc
     */
    public function create($alias)
    {
        if (!isset($this->presenters[$alias])) {
            throw new \InvalidArgumentException(sprintf('[%s] presenter not supported.', $alias));
        }

        return $this->presenters[$alias];
    }
}
