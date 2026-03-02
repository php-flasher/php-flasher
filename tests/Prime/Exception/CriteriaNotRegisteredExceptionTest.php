<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Exception;

use Flasher\Prime\Exception\CriteriaNotRegisteredException;
use PHPUnit\Framework\TestCase;

final class CriteriaNotRegisteredExceptionTest extends TestCase
{
    public function testCreateWithAliasOnly(): void
    {
        $exception = CriteriaNotRegisteredException::create('custom_criteria');

        $this->assertSame('Criteria "custom_criteria" not found, did you forget to register it?', $exception->getMessage());
    }

    public function testCreateWithAvailableCriteria(): void
    {
        $exception = CriteriaNotRegisteredException::create('custom_criteria', ['limit', 'order_by', 'filter']);

        $this->assertSame('Criteria "custom_criteria" not found, did you forget to register it? Available criteria: [limit, order_by, filter]', $exception->getMessage());
    }

    public function testCreateWithEmptyAvailableCriteria(): void
    {
        $exception = CriteriaNotRegisteredException::create('custom_criteria', []);

        $this->assertSame('Criteria "custom_criteria" not found, did you forget to register it?', $exception->getMessage());
    }

    public function testIsException(): void
    {
        $exception = CriteriaNotRegisteredException::create('test');

        $this->assertInstanceOf(\Exception::class, $exception);
    }
}
