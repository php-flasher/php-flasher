<?php

declare(strict_types=1);

namespace Flasher\Prime\Asset;

/**
 * AssetManagerInterface - Contract for asset management services.
 *
 * This interface defines the essential operations for managing web assets,
 * particularly focusing on path resolution and manifest generation for versioning.
 *
 * Design pattern: Strategy - Defines a common interface for different asset
 * management strategies that can be used interchangeably.
 */
interface AssetManagerInterface
{
    /**
     * Resolves the given path to its hashed version if available in the manifest.
     *
     * This method should look up the original path in a manifest of versioned assets
     * and return the versioned path if found. Otherwise, it should return the original path.
     *
     * @param string $path The original file path
     *
     * @return string The resolved file path with version hash or the original path if not found
     */
    public function getPath(string $path): string;

    /**
     * Resolves multiple paths to their hashed versions if available.
     *
     * This is a batch version of getPath() that processes multiple paths at once.
     *
     * @param string[] $paths Array of original file paths
     *
     * @return string[] Array of resolved file paths in the same order
     */
    public function getPaths(array $paths): array;

    /**
     * Generates a JSON manifest from given files.
     *
     * This method should create a mapping between original file paths and
     * versioned paths (typically with content hashes) and save it to a manifest file.
     *
     * @param string[] $files Array of file paths to include in the manifest
     *
     * @throws \RuntimeException If the manifest cannot be created
     */
    public function createManifest(array $files): void;
}
