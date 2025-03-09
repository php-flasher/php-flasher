<?php

declare(strict_types=1);

namespace Flasher\Prime\Asset;

/**
 * AssetManager - Manages asset files and their versioning via a manifest file.
 *
 * This class provides functionality for handling asset versioning through a manifest
 * file that maps original asset paths to versioned paths with hash parameters.
 * The asset versioning helps with cache busting by appending a content hash to the URL.
 *
 * Design patterns:
 * - Resource Manager: Centralized management of web asset resources
 * - Cache Buster: Handles versioning of assets to ensure browser cache invalidation
 */
final class AssetManager implements AssetManagerInterface
{
    /**
     * Cached manifest entries mapping original paths to versioned paths.
     *
     * @var array<string, string>
     */
    private array $entries = [];

    /**
     * Creates a new AssetManager instance.
     *
     * @param string $publicDir    The public directory where assets are located
     * @param string $manifestPath The path to the manifest file
     */
    public function __construct(
        private readonly string $publicDir,
        private readonly string $manifestPath,
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * This implementation first checks for an exact match in the manifest,
     * then tries with directory separators normalized, and falls back to the
     * original path if no match is found.
     */
    public function getPath(string $path): string
    {
        $entriesData = $this->getEntriesData();

        return $entriesData[$path] ?? $entriesData[ltrim($path, \DIRECTORY_SEPARATOR)] ?? $path;
    }

    public function getPaths(array $paths): array
    {
        return array_map(fn (string $path) => $this->getPath($path), $paths);
    }

    /**
     * {@inheritdoc}
     *
     * This method:
     * 1. Processes each file to calculate its content hash
     * 2. Creates a mapping from relative paths to versioned paths
     * 3. Writes the mapping to the manifest file as JSON
     *
     * @throws \RuntimeException If unable to write to the manifest file
     */
    public function createManifest(array $files): void
    {
        foreach ($files as $file) {
            if (!file_exists($file)) {
                continue;
            }

            $relativePath = \DIRECTORY_SEPARATOR.ltrim(str_replace($this->publicDir, '', $file), \DIRECTORY_SEPARATOR);
            $relativePath = str_replace(\DIRECTORY_SEPARATOR, '/', $relativePath);

            $hash = $this->computeHash($file);
            $hashedFilename = $relativePath.'?id='.$hash;

            $this->entries[$relativePath] = $hashedFilename;
        }

        if (false === file_put_contents($this->manifestPath, json_encode($this->entries, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES))) {
            throw new \RuntimeException(\sprintf('Failed to write manifest file to "%s"', $this->manifestPath));
        }
    }

    /**
     * Loads and returns the entries from the manifest file.
     *
     * This method lazily loads the manifest data and caches it for subsequent calls.
     * If no manifest file exists or it cannot be parsed, an empty array is returned.
     *
     * @return array<string, string> The manifest entries mapping original to versioned paths
     *
     * @throws \InvalidArgumentException If the manifest file contains invalid JSON
     */
    private function getEntriesData(): array
    {
        if ([] !== $this->entries) {
            return $this->entries;
        }

        if (!file_exists($this->manifestPath)) {
            return [];
        }

        $content = file_get_contents($this->manifestPath);
        $entries = json_decode($content ?: '', true);

        if (!\is_array($entries)) {
            throw new \InvalidArgumentException(\sprintf('There was a problem JSON decoding the "%s" file.', $this->manifestPath));
        }

        return $this->entries = $entries; // @phpstan-ignore-line
    }

    /**
     * Computes a hash for a file based on its contents.
     *
     * This method normalizes line endings to ensure consistent hashing
     * across different platforms.
     *
     * @param string $path The path to the file
     *
     * @return string The MD5 hash of the file contents or empty string if file cannot be read
     */
    private function computeHash(string $path): string
    {
        $contents = file_get_contents($path);

        if (false === $contents) {
            return '';
        }

        $normalizedContents = str_replace(["\r\n", "\r"], "\n", $contents);

        return md5($normalizedContents);
    }
}
