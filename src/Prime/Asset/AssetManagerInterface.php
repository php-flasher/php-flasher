<?php

declare(strict_types=1);

namespace Flasher\Prime\Asset;

interface AssetManagerInterface
{
    public function getPath(string $path): string;

    /**
     * @param string[] $paths
     *
     * @return string[]
     */
    public function getPaths(array $paths): array;

    /**
     * @param string[] $files
     */
    public function createManifest(array $files): void;
}
