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
        $criteria = $this->decodeJson($this->criteria);

        /** @var array<string, mixed> $context */
        $context = $this->decodeJson($this->context);

        return app('flasher')->render('html', $criteria, $context);
    }

    /**
     * Safely decode JSON string, returning empty array on failure.
     *
     * @return array<string, mixed>
     */
    private function decodeJson(string $json): array
    {
        if ('' === $json) {
            return [];
        }

        try {
            $decoded = json_decode($json, true, 512, \JSON_THROW_ON_ERROR);

            return \is_array($decoded) ? $decoded : [];
        } catch (\JsonException) {
            return [];
        }
    }
}
