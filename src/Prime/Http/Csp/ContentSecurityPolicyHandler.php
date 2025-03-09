<?php

declare(strict_types=1);

namespace Flasher\Prime\Http\Csp;

use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseInterface;

/**
 * ContentSecurityPolicyHandler - Manages Content Security Policy for PHPFlasher.
 *
 * This class handles the complex task of managing Content Security Policy (CSP) headers
 * to allow PHPFlasher's JavaScript and CSS to run securely. It generates nonces for
 * scripts and styles, modifies CSP headers to include these nonces, and ensures that
 * inline code can execute without being blocked by CSP.
 *
 * Design patterns:
 * - Strategy: Implements a specific approach to CSP handling
 * - Adapter: Works with different request and response implementations
 */
final class ContentSecurityPolicyHandler implements ContentSecurityPolicyHandlerInterface
{
    /**
     * Header for passing script nonce between components.
     */
    private const SCRIPT_NONCE_HEADER = 'X-PHPFlasher-Script-Nonce';

    /**
     * Header for passing style nonce between components.
     */
    private const STYLE_NONCE_HEADER = 'X-PHPFlasher-Style-Nonce';

    /**
     * Whether CSP handling is disabled.
     */
    private bool $cspDisabled = false;

    /**
     * Creates a new ContentSecurityPolicyHandler instance.
     *
     * @param NonceGeneratorInterface $nonceGenerator The generator for creating secure nonces
     */
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
     * This method checks if the necessary nonce headers are present in the provided
     * request or response object and returns their values if found.
     *
     * @param RequestInterface|ResponseInterface $object The object to check for nonce headers
     *
     * @return array{csp_script_nonce: ?string, csp_style_nonce: ?string}|null Nonce values or null if not found
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

    /**
     * Removes temporary nonce headers from the response.
     *
     * These headers are used internally to pass nonces between components but
     * should not be sent to the client.
     *
     * @param ResponseInterface $response The response to clean
     */
    private function cleanHeaders(ResponseInterface $response): void
    {
        $response->removeHeader(self::SCRIPT_NONCE_HEADER);
        $response->removeHeader(self::STYLE_NONCE_HEADER);
    }

    /**
     * Removes all CSP headers from the response.
     *
     * This is used when CSP handling is disabled to ensure no CSP restrictions are applied.
     *
     * @param ResponseInterface $response The response to modify
     */
    private function removeCspHeaders(ResponseInterface $response): void
    {
        $response->removeHeader('X-Content-Security-Policy');
        $response->removeHeader('Content-Security-Policy');
        $response->removeHeader('Content-Security-Policy-Report-Only');
    }

    /**
     * Updates Content-Security-Policy headers in a response.
     *
     * This method modifies existing CSP headers to include nonces for PHPFlasher's
     * JavaScript and CSS, allowing them to execute without being blocked by CSP.
     *
     * @param ResponseInterface                                            $response The response to modify
     * @param array{csp_script_nonce?: ?string, csp_style_nonce?: ?string} $nonces   The nonces to add to CSP
     *
     * @return array{csp_script_nonce?: ?string, csp_style_nonce?: ?string} The nonces used
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
     *
     * @return string The generated nonce
     */
    private function generateNonce(): string
    {
        return $this->nonceGenerator->generate();
    }

    /**
     * Converts a directive set array into Content-Security-Policy header value.
     *
     * @param array<string, string[]> $directives The CSP directives to convert
     *
     * @return string The formatted CSP header value
     */
    private function generateCspHeader(array $directives): string
    {
        return array_reduce(array_keys($directives), fn ($res, $name) => ('' !== $res ? $res.'; ' : '').\sprintf('%s %s', $name, implode(' ', $directives[$name])), '');
    }

    /**
     * Converts a Content-Security-Policy header value into a directive set array.
     *
     * @param string|null $header The CSP header value to parse
     *
     * @return array<string, string[]> The parsed directive set
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
     * Detects if the 'unsafe-inline' is permitted for a directive within the directive set.
     *
     * This method checks if a specific CSP directive allows inline scripts or styles,
     * taking into account CSP level 2+ hash and nonce exceptions.
     *
     * @param array<string, string[]> $directivesSet The directives to check
     * @param string                  $type          The directive type to check
     *
     * @return bool True if inline content is permitted
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
     * Checks if a directive list contains hash or nonce restrictions.
     *
     * This is important for CSP processing because in CSP Level 2+, the presence of a
     * hash or nonce invalidates 'unsafe-inline' even if it's present.
     *
     * @param string[] $directives The CSP directive values to check
     *
     * @return bool True if the directive list contains a hash or nonce restriction
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
     * Finds the fallback directive for a specific directive type.
     *
     * In CSP, if a specific directive isn't defined, browsers fall back to default-src.
     * This method implements that behavior for the PHPFlasher CSP handler.
     *
     * @param array<string, string[]> $directiveSet The complete directive set
     * @param string                  $type         The directive type to find a fallback for
     *
     * @return string[]|null The fallback directive values, or null if no fallback exists
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
     * Retrieves the Content-Security-Policy headers from a response.
     *
     * This method extracts all CSP-related headers from the response
     * and parses their values into directive sets.
     *
     * @param ResponseInterface $response The response to extract CSP headers from
     *
     * @return array{
     *     Content-Security-Policy?: array<string, string[]>,
     *     Content-Security-Policy-Report-Only?: array<string, string[]>,
     *     X-Content-Security-Policy?: array<string, string[]>,
     * } Mapped CSP headers and their parsed directive sets
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
