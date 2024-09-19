<?php

declare(strict_types=1);

namespace Flasher\Prime\Http\Csp;

use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseInterface;

final class ContentSecurityPolicyHandler implements ContentSecurityPolicyHandlerInterface
{
    private const SCRIPT_NONCE_HEADER = 'X-PHPFlasher-Script-Nonce';
    private const STYLE_NONCE_HEADER = 'X-PHPFlasher-Style-Nonce';

    private bool $cspDisabled = false;

    public function __construct(private readonly NonceGeneratorInterface $nonceGenerator)
    {
    }

    public function getNonces(RequestInterface $request, ?ResponseInterface $response = null): array
    {
        if ($nonces = $this->getHeaderNonces($request)) {
            return $nonces;
        }

        if ($response && $nonces = $this->getHeaderNonces($response)) {
            return $nonces;
        }

        $nonces = [
            'csp_script_nonce' => $this->generateNonce(),
            'csp_style_nonce' => $this->generateNonce(),
        ];

        $response?->setHeader(self::SCRIPT_NONCE_HEADER, $nonces['csp_script_nonce']);
        $response?->setHeader(self::STYLE_NONCE_HEADER, $nonces['csp_style_nonce']);

        return $nonces;
    }

    public function disableCsp(): void
    {
        $this->cspDisabled = true;
    }

    public function updateResponseHeaders(RequestInterface $request, ResponseInterface $response): array
    {
        if ($this->cspDisabled) {
            $this->removeCspHeaders($response);

            return [];
        }

        $nonces = $this->getNonces($request, $response);
        $this->cleanHeaders($response);
        $this->updateCspHeaders($response, $nonces);

        return $nonces;
    }

    /**
     * Returns nonces from headers if existing, otherwise null.
     *
     * @return array{csp_script_nonce: ?string, csp_style_nonce: ?string}|null
     */
    private function getHeaderNonces(RequestInterface|ResponseInterface $object): ?array
    {
        if ($object->hasHeader(self::SCRIPT_NONCE_HEADER) && $object->hasHeader(self::STYLE_NONCE_HEADER)) {
            return [
                'csp_script_nonce' => $object->getHeader(self::SCRIPT_NONCE_HEADER),
                'csp_style_nonce' => $object->getHeader(self::STYLE_NONCE_HEADER),
            ];
        }

        return null;
    }

    private function cleanHeaders(ResponseInterface $response): void
    {
        $response->removeHeader(self::SCRIPT_NONCE_HEADER);
        $response->removeHeader(self::STYLE_NONCE_HEADER);
    }

    private function removeCspHeaders(ResponseInterface $response): void
    {
        $response->removeHeader('X-Content-Security-Policy');
        $response->removeHeader('Content-Security-Policy');
        $response->removeHeader('Content-Security-Policy-Report-Only');
    }

    /**
     * Updates Content-Security-Policy headers in a response.
     *
     * @param array{csp_script_nonce?: ?string, csp_style_nonce?: ?string} $nonces
     *
     * @return array{csp_script_nonce?: ?string, csp_style_nonce?: ?string}
     */
    private function updateCspHeaders(ResponseInterface $response, array $nonces = []): array
    {
        $nonces = array_replace([
            'csp_script_nonce' => $this->generateNonce(),
            'csp_style_nonce' => $this->generateNonce(),
        ], $nonces);

        $ruleIsSet = false;

        $headers = $this->getCspHeaders($response);

        $types = [
            'script-src' => 'csp_script_nonce',
            'script-src-elem' => 'csp_script_nonce',
            'style-src' => 'csp_style_nonce',
            'style-src-elem' => 'csp_style_nonce',
        ];

        foreach ($headers as $header => $directives) {
            foreach ($types as $type => $tokenName) {
                if ($this->authorizesInline($directives, $type)) {
                    continue;
                }
                if (!isset($headers[$header][$type])) {
                    if (null === $fallback = $this->getDirectiveFallback($directives, $type)) {
                        continue;
                    }

                    if (['\'none\''] === $fallback) {
                        // Fallback came from "default-src: 'none'"
                        // 'none' is invalid if it's not the only expression in the source list, so we leave it out
                        $fallback = [];
                    }

                    $headers[$header][$type] = $fallback;
                }
                $ruleIsSet = true;
                if (!\in_array('\'unsafe-inline\'', $headers[$header][$type], true)) {
                    $headers[$header][$type][] = '\'unsafe-inline\'';
                }
                $headers[$header][$type][] = \sprintf('\'nonce-%s\'', $nonces[$tokenName]);
            }
        }

        if (!$ruleIsSet) {
            return $nonces;
        }

        foreach ($headers as $header => $directives) {
            $response->setHeader($header, $this->generateCspHeader($directives));
        }

        return $nonces;
    }

    /**
     * Generates a valid Content-Security-Policy nonce.
     */
    private function generateNonce(): string
    {
        return $this->nonceGenerator->generate();
    }

    /**
     * Converts a directive set array into Content-Security-Policy header.
     *
     * @param array<string, string[]> $directives
     */
    private function generateCspHeader(array $directives): string
    {
        return array_reduce(array_keys($directives), fn ($res, $name) => ('' !== $res ? $res.'; ' : '').\sprintf('%s %s', $name, implode(' ', $directives[$name])), '');
    }

    /**
     * Converts a Content-Security-Policy header value into a directive set array.
     *
     * @return array<string, string[]>
     */
    private function parseDirectives(?string $header): array
    {
        $directives = [];

        foreach (explode(';', $header ?: '') as $directive) {
            $parts = explode(' ', trim($directive));
            if (\count($parts) < 1) { // @phpstan-ignore-line
                continue;
            }
            $name = array_shift($parts);
            $directives[$name] = $parts;
        }

        return $directives;
    }

    /**
     * Detects if the 'unsafe-inline' is prevented for a directive within the directive set.
     *
     * @param array<string, string[]> $directivesSet
     */
    private function authorizesInline(array $directivesSet, string $type): bool
    {
        if (isset($directivesSet[$type])) {
            $directives = $directivesSet[$type];
        } elseif (null === $directives = $this->getDirectiveFallback($directivesSet, $type)) {
            return false;
        }

        return \in_array('\'unsafe-inline\'', $directives, true) && !$this->hasHashOrNonce($directives);
    }

    /**
     * @param string[] $directives
     */
    private function hasHashOrNonce(array $directives): bool
    {
        foreach ($directives as $directive) {
            if (!str_ends_with($directive, '\'')) {
                continue;
            }
            if (str_starts_with($directive, '\'nonce-')) {
                return true;
            }
            if (\in_array(substr($directive, 0, 8), ['\'sha256-', '\'sha384-', '\'sha512-'], true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<string, string[]> $directiveSet
     *
     * @return string[]|null
     */
    private function getDirectiveFallback(array $directiveSet, string $type): ?array
    {
        if (\in_array($type, ['script-src-elem', 'style-src-elem'], true) || !isset($directiveSet['default-src'])) {
            // Let the browser fallback on it's own
            return null;
        }

        return $directiveSet['default-src'];
    }

    /**
     * Retrieves the Content-Security-Policy headers (either X-Content-Security-Policy or Content-Security-Policy) from
     * a response.
     *
     * @return array{
     *     Content-Security-Policy?: array<string, string[]>,
     *     Content-Security-Policy-Report-Only?: array<string, string[]>,
     *     X-Content-Security-Policy?: array<string, string[]>,
     * }
     */
    private function getCspHeaders(ResponseInterface $response): array
    {
        $headers = [];

        if ($response->hasHeader('Content-Security-Policy')) {
            $headers['Content-Security-Policy'] = $this->parseDirectives($response->getHeader('Content-Security-Policy'));
        }

        if ($response->hasHeader('Content-Security-Policy-Report-Only')) {
            $headers['Content-Security-Policy-Report-Only'] = $this->parseDirectives($response->getHeader('Content-Security-Policy-Report-Only'));
        }

        if ($response->hasHeader('X-Content-Security-Policy')) {
            $headers['X-Content-Security-Policy'] = $this->parseDirectives($response->getHeader('X-Content-Security-Policy'));
        }

        return $headers;
    }
}
