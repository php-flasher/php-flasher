<?php

declare(strict_types=1);

namespace Flasher\Prime\Asset;

interface AssetManagerInterface
{
    /**
     * Resolves the given path to its hashed version if available in the manifest.
     *
     * @param string $path the original file path
     *
     * @return string the resolved file path or the original path if not found in the manifest
     */
    public function getPath(string $path): string;

    /**
     * @param string[] $paths
     *
     * @return string[]
     */
    public function getPaths(array $paths): array;

    /**
     * Generates a json manifest from given files.
     *
     * @param string[] $files array of file paths
     */
    public function createManifest(array $files): void;
}
