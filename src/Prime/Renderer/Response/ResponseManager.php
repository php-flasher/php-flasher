<?php

namespace Flasher\Prime\Renderer\Response;

final class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var array<string, ResponseInterface>
     */
    private $responses;

    public function __construct()
    {
        $this->addResponse('array', new ArrayResponse());
        $this->addResponse('html', new HtmlResponse());
    }

    /**
     * @inheritDoc
     */
    public function addResponse($alias, ResponseInterface $response)
    {
        $this->responses[$alias] = $response;
    }

    /**
     * @inheritDoc
     */
    public function create($alias)
    {
        if (!isset($this->responses[$alias])) {
            throw new \InvalidArgumentException(sprintf('[%s] response not supported.', $alias));
        }

        return $this->responses[$alias];
    }
}
