<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Storage\Filter\Criteria\RangeExtractor;
use PHPUnit\Framework\TestCase;

final class RangeExtractorTest extends TestCase
{
    private object $traitInstance;

    protected function setUp(): void
    {
        parent::setUp();

        $this->traitInstance = new class() {
            use RangeExtractor;

            public function testExtractRange(string $name, mixed $criteria): array
            {
                return $this->extractRange($name, $criteria);
            }
        };
    }

    public function testExtractRangeWithInteger(): void
    {
        $result = $this->traitInstance->testExtractRange('test', 5);

        $this->assertSame(['min' => 5, 'max' => null], $result);
    }

    public function testExtractRangeWithZeroInteger(): void
    {
        $result = $this->traitInstance->testExtractRange('test', 0);

        $this->assertSame(['min' => 0, 'max' => null], $result);
    }

    public function testExtractRangeWithNegativeInteger(): void
    {
        $result = $this->traitInstance->testExtractRange('test', -5);

        $this->assertSame(['min' => -5, 'max' => null], $result);
    }

    public function testExtractRangeWithArrayContainingMin(): void
    {
        $result = $this->traitInstance->testExtractRange('test', ['min' => 3]);

        $this->assertSame(['min' => 3, 'max' => null], $result);
    }

    public function testExtractRangeWithArrayContainingMax(): void
    {
        $result = $this->traitInstance->testExtractRange('test', ['max' => 10]);

        $this->assertSame(['min' => null, 'max' => 10], $result);
    }

    public function testExtractRangeWithArrayContainingBoth(): void
    {
        $result = $this->traitInstance->testExtractRange('test', ['min' => 3, 'max' => 10]);

        $this->assertSame(['min' => 3, 'max' => 10], $result);
    }

    public function testExtractRangeWithEmptyArray(): void
    {
        $result = $this->traitInstance->testExtractRange('test', []);

        $this->assertSame(['min' => null, 'max' => null], $result);
    }

    public function testExtractRangeWithExtraKeys(): void
    {
        $result = $this->traitInstance->testExtractRange('test', ['min' => 1, 'max' => 5, 'extra' => 'ignored']);

        $this->assertSame(['min' => 1, 'max' => 5], $result);
    }

    public function testExtractRangeWithNullMin(): void
    {
        $result = $this->traitInstance->testExtractRange('test', ['min' => null, 'max' => 5]);

        $this->assertSame(['min' => null, 'max' => 5], $result);
    }

    public function testExtractRangeWithNullMax(): void
    {
        $result = $this->traitInstance->testExtractRange('test', ['min' => 5, 'max' => null]);

        $this->assertSame(['min' => 5, 'max' => null], $result);
    }

    public function testExtractRangeWithInvalidTypeString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "test"');
        $this->expectExceptionMessage('Expected int or array, got "string"');

        $this->traitInstance->testExtractRange('test', 'invalid');
    }

    public function testExtractRangeWithInvalidTypeFloat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "test"');
        $this->expectExceptionMessage('Expected int or array, got "float"');

        $this->traitInstance->testExtractRange('test', 3.14);
    }

    public function testExtractRangeWithInvalidTypeNull(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "test"');
        $this->expectExceptionMessage('Expected int or array, got "null"');

        $this->traitInstance->testExtractRange('test', null);
    }

    public function testExtractRangeWithInvalidTypeBool(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "test"');
        $this->expectExceptionMessage('Expected int or array, got "bool"');

        $this->traitInstance->testExtractRange('test', true);
    }

    public function testExtractRangeWithInvalidTypeObject(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "test"');
        $this->expectExceptionMessage('Expected int or array, got "stdClass"');

        $this->traitInstance->testExtractRange('test', new \stdClass());
    }

    public function testExtractRangeWithInvalidMinTypeString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "min" in criteria "test"');
        $this->expectExceptionMessage('Expected int, got "string"');

        $this->traitInstance->testExtractRange('test', ['min' => 'invalid']);
    }

    public function testExtractRangeWithInvalidMinTypeFloat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "min" in criteria "test"');
        $this->expectExceptionMessage('Expected int, got "float"');

        $this->traitInstance->testExtractRange('test', ['min' => 3.14]);
    }

    public function testExtractRangeWithInvalidMinTypeArray(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "min" in criteria "test"');
        $this->expectExceptionMessage('Expected int, got "array"');

        $this->traitInstance->testExtractRange('test', ['min' => [1, 2]]);
    }

    public function testExtractRangeWithInvalidMinTypeNullIsAllowed(): void
    {
        $result = $this->traitInstance->testExtractRange('test', ['min' => null]);

        $this->assertNull($result['min']);
    }

    public function testExtractRangeWithInvalidMaxTypeString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "max" in criteria "test"');
        $this->expectExceptionMessage('Expected int, got "string"');

        $this->traitInstance->testExtractRange('test', ['max' => 'invalid']);
    }

    public function testExtractRangeWithInvalidMaxTypeFloat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "max" in criteria "test"');
        $this->expectExceptionMessage('Expected int, got "float"');

        $this->traitInstance->testExtractRange('test', ['max' => 3.14]);
    }

    public function testExtractRangeWithInvalidMaxTypeArray(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "max" in criteria "test"');
        $this->expectExceptionMessage('Expected int, got "array"');

        $this->traitInstance->testExtractRange('test', ['max' => [1, 2]]);
    }

    public function testExtractRangeWithInvalidMaxTypeNullIsAllowed(): void
    {
        $result = $this->traitInstance->testExtractRange('test', ['max' => null]);

        $this->assertNull($result['max']);
    }

    public function testExtractRangeUsesNameInErrorMessage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "custom_criteria_name"');

        $this->traitInstance->testExtractRange('custom_criteria_name', 'invalid');
    }

    public function testExtractRangeWithMinInErrorMessage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "min" in criteria "priority"');

        $this->traitInstance->testExtractRange('priority', ['min' => 'bad']);
    }
}
