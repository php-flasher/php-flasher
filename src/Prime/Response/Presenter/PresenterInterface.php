<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

interface PresenterInterface
{
    public function render(Response $response): mixed;
}
