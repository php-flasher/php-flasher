<?php

namespace Flasher\Prime\Stamp;

final class ContextStamp implements StampInterface, PresentableStampInterface
{
    /**
     * @var mixed[]
     */
    private $context;

    /**
     * @param mixed[] $context
     */
    public function __construct(array $context)
    {
        $this->context = $context;
    }

    /**
     * @return mixed[]
     */
    public function getContext()
    {
        return $this->context;
    }

    public function toArray()
    {
        return ['context' => $this->getContext()];
    }
}
