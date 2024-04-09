<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Http\Csp;

use Flasher\Prime\Http\Csp\NonceGenerator;
use PHPUnit\Framework\TestCase;

/**
 * The generate() method of the NonceGenerator class provides randomly generated
 * hexadecimal string each time it is called. This test suite validates that each
 * nonce is truly unique, meets the length requirements and is a valid hexadecimal string.
 */
final class NonceGeneratorTest extends TestCase
{
    private NonceGenerator $nonceGenerator;

    protected function setUp(): void
    {
        $this->nonceGenerator = new NonceGenerator();
    }

    /**
     * testGenerateMethodUnique check that the nonce generated is unique.
     */
    public function testGenerateMethodUnique(): void
    {
        $nonces = [];

        // Generate a list of nonces
        for ($i = 0; $i < 10; ++$i) {
            $nonces[] = $this->nonceGenerator->generate();
        }

        // Check that there are no duplicate values
        $this->assertCount(10, array_unique($nonces));
    }

    /**
     * testGenerateMethodHexadecimal check that the nonce generated is a valid hexadecimal string.
     */
    public function testGenerateMethodHexadecimal(): void
    {
        // Generate a nonce
        $nonce = $this->nonceGenerator->generate();

        // Check that the nonce is a valid hexadecimal string
        $this->assertTrue(ctype_xdigit($nonce));
    }

    /**
     * testGenerateMethodLength check that the nonce generated is indeed 32 characters long.
     */
    public function testGenerateMethodLength(): void
    {
        // Generate a nonce
        $nonce = $this->nonceGenerator->generate();

        // Check that the nonce is the correct length
        $this->assertSame(32, \strlen($nonce));
    }
}
