<?php

declare(strict_types=1);

namespace Flasher\Prime\Response;

use Flasher\Prime\Response\Presenter\ArrayPresenter;
use Flasher\Prime\Response\Presenter\PresenterInterface;

/**
 * @phpstan-import-type ArrayPresenterType from ArrayPresenter
 */
interface ResponseManagerInterface
{
    /**
     * @param array<string, mixed> $criteria
     * @param array<string, mixed> $context
     *
     * @phpstan-return ($presenter is 'html' ? string :
     *           ($presenter is 'array' ? ArrayPresenterType :
     *           ($presenter is 'json' ? ArrayPresenterType :
     *                       mixed)))
     */
    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed;

    public function addPresenter(string $alias, callable|PresenterInterface $presenter): void;
}
