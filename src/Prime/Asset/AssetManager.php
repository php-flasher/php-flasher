<?php

declare(strict_types=1);

namespace Flasher\Prime\Asset;

final class AssetManager implements AssetManagerInterface
{
    /**
     * @var array<string, string>
     */
    private array $entries = [];

    public function __construct(
        private readonly string $publicDir,
        private readonly string $manifestPath,
        private readonly string $publicPath = '',
    ) {
    }

    public function getPath(string $path): string
    {
        $entriesData = $this->getEntriesData();
        $resolved = $entriesData[$path] ?? $entriesData[ltrim($path, \DIRECTORY_SEPARATOR)] ?? $path;

        return $this->prependPublicPath($resolved);
    }

    public function getPaths(array $paths): array
    {
        return array_map(fn (string $path) => $this->getPath($path), $paths);
    }

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
     * @return array<string, string>
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

    private function prependPublicPath(string $path): string
    {
        if ('' === $this->publicPath || '' === $path) {
            return $path;
        }

        if (1 === preg_match('#^(?:[a-z][a-z0-9+\-.]*:)?//#i', $path) || str_starts_with($path, 'data:')) {
            return $path;
        }

        $prefix = rtrim($this->publicPath, '/');
        if ('' === $prefix) {
            return $path;
        }

        if (str_starts_with($path, $prefix.'/')) {
            return $path;
        }

        return $prefix.'/'.ltrim($path, '/');
    }

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
