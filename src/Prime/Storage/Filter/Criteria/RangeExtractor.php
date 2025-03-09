<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

/**
 * RangeExtractor - Helper trait for extracting range values from criteria.
 *
 * This trait provides common functionality for criteria that operate on
 * numeric ranges. It standardizes how min/max range values are extracted
 * from various input formats.
 *
 * Design pattern: Utility - Provides reusable functionality across multiple classes.
 */
trait RangeExtractor
{
    /**
     * Extracts a range from the given criteria.
     *
     * This method standardizes range extraction from various input formats:
     * - An integer value is treated as a minimum threshold
     * - An array with 'min' and/or 'max' keys specifies a range
     *
     * @param string $name     The name of the criteria (for error messages)
     * @param mixed  $criteria The criteria value to extract range from
     *
     * @return array{min: ?int, max: ?int} An associative array with 'min' and 'max' keys
     *
     * @throws \InvalidArgumentException If the criteria is not of an expected type
     */
    private function extractRange(string $name, mixed $criteria): array
    {
        if (!\is_int($criteria) && !\is_array($criteria)) {
            throw new \InvalidArgumentException(\sprintf('Invalid type for criteria "%s". Expected int or array, got "%s".', $name, get_debug_type($criteria)));
        }

        if (\is_int($criteria)) {
            return ['min' => $criteria, 'max' => null];
        }

        $min = $criteria['min'] ?? null;
        $max = $criteria['max'] ?? null;

        if (null !== $min && !\is_int($min)) {
            throw new \InvalidArgumentException(\sprintf('Invalid type for "min" in criteria "%s". Expected int, got "%s".', $name, get_debug_type($min)));
        }

        if (null !== $max && !\is_int($max)) {
            throw new \InvalidArgumentException(\sprintf('Invalid type for "max" in criteria "%s". Expected int, got "%s".', $name, get_debug_type($max)));
        }

        return ['min' => $min, 'max' => $max];
    }
}
