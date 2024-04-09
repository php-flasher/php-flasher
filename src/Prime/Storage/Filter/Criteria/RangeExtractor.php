<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

trait RangeExtractor
{
    /**
     * Extracts a range from the given criteria.
     *
     * @param string $name     the name of the criteria
     * @param mixed  $criteria the criteria value
     *
     * @return array{min: ?int, max: ?int} an associative array with 'min' and 'max' keys
     *
     * @throws \InvalidArgumentException if the criteria is not of an expected type
     */
    private function extractRange(string $name, mixed $criteria): array
    {
        if (!\is_int($criteria) && !\is_array($criteria)) {
            throw new \InvalidArgumentException(sprintf('Invalid type for criteria "%s". Expected int or array, got "%s".', $name, get_debug_type($criteria)));
        }

        if (\is_int($criteria)) {
            return ['min' => $criteria, 'max' => null];
        }

        $min = $criteria['min'] ?? null;
        $max = $criteria['max'] ?? null;

        if (null !== $min && !\is_int($min)) {
            throw new \InvalidArgumentException(sprintf('Invalid type for "min" in criteria "%s". Expected int, got "%s".', $name, get_debug_type($min)));
        }

        if (null !== $max && !\is_int($max)) {
            throw new \InvalidArgumentException(sprintf('Invalid type for "max" in criteria "%s". Expected int, got "%s".', $name, get_debug_type($max)));
        }

        return ['min' => $min, 'max' => $max];
    }
}
