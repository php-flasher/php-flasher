<?php

declare(strict_types=1);

namespace Flasher\Prime\Response;

use Flasher\Prime\Response\Presenter\PresenterInterface;

interface ResponseManagerInterface
{
    /**
     * @param array<string, mixed> $criteria
     * @param array<string, mixed> $context
     */
    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed;

    public function addPresenter(string $alias, callable|PresenterInterface $presenter): void;
}
