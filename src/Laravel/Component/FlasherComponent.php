<?php

declare(strict_types=1);

namespace Flasher\Laravel\Component;

use Illuminate\View\Component;

final class FlasherComponent extends Component
{
    public function __construct(public string $criteria = '', public string $context = '')
    {
    }

    public function render(): string
    {
        /** @var array<string, mixed> $criteria */
        $criteria = json_decode($this->criteria, true, 512, \JSON_THROW_ON_ERROR) ?: [];

        /** @var array<string, mixed> $context */
        $context = json_decode($this->context, true, 512, \JSON_THROW_ON_ERROR) ?: [];

        return app('flasher')->render('html', $criteria, $context);
    }
}
