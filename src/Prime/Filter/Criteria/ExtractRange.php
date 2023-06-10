<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Criteria;

trait ExtractRange
{
    /**
     * @return array{min: ?int, max: ?int}
     */
    private function extractRange(string $name, mixed $criteria): array
    {
        if (! is_int($criteria) && ! is_array($criteria)) {
            throw new \InvalidArgumentException(sprintf('Invalid type for criteria "%s". Expected int or array got "%s".', $name, get_debug_type($criteria)));
        }

        if (! \is_array($criteria)) {
            $criteria = ['min' => $criteria];
        }

        $min = $criteria['min'] ?? null;
        $max = $criteria['max'] ?? null;

        return ['min' => $min, 'max' => $max];
    }
}
