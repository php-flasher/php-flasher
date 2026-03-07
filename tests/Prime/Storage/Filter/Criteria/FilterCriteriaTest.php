<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Storage\Filter\Criteria\FilterCriteria;
use PHPUnit\Framework\TestCase;

final class FilterCriteriaTest extends TestCase
{
    public function testConstructorWithClosure(): void
    {
        $criteria = new FilterCriteria(fn ($envelopes) => $envelopes);

        $this->assertInstanceOf(FilterCriteria::class, $criteria);
    }

    public function testConstructorWithArrayOfClosures(): void
    {
        $criteria = new FilterCriteria([
            fn ($envelopes) => $envelopes,
            fn ($envelopes) => array_filter($envelopes),
        ]);

        $this->assertInstanceOf(FilterCriteria::class, $criteria);
    }

    public function testConstructorWithInvalidTypeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "filter"');

        new FilterCriteria('not a closure');
    }

    public function testConstructorWithNullThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "filter"');

        new FilterCriteria(null);
    }

    public function testConstructorWithArrayContainingNonClosureThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Each element must be a closure');

        new FilterCriteria([fn ($e) => $e, 'not a closure']);
    }

    public function testApplyWithSingleClosure(): void
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $criteria = new FilterCriteria(fn ($e) => \array_slice($e, 0, 2));

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithMultipleClosures(): void
    {
        $notification1 = new Notification();
        $notification1->setType('success');
        $notification2 = new Notification();
        $notification2->setType('error');
        $notification3 = new Notification();
        $notification3->setType('success');

        $envelopes = [
            new Envelope($notification1),
            new Envelope($notification2),
            new Envelope($notification3),
        ];

        $criteria = new FilterCriteria([
            fn ($e) => array_filter($e, fn (Envelope $envelope) => 'success' === $envelope->getType()),
            fn ($e) => \array_slice($e, 0, 1),
        ]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
        $this->assertSame('success', $result[0]->getType());
    }

    public function testApplyWithEmptyArray(): void
    {
        $criteria = new FilterCriteria(fn ($e) => $e);

        $result = $criteria->apply([]);

        $this->assertSame([], $result);
    }

    public function testApplyThatReturnsModifiedEnvelopes(): void
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $criteria = new FilterCriteria(fn ($e) => []);

        $result = $criteria->apply($envelopes);

        $this->assertSame([], $result);
    }

    public function testClosureReceivesCorrectArguments(): void
    {
        $received = null;
        $envelopes = [new Envelope(new Notification())];

        $criteria = new FilterCriteria(function ($e) use (&$received) {
            $received = $e;

            return $e;
        });

        $criteria->apply($envelopes);

        $this->assertSame($envelopes, $received);
    }

    public function testChainedFiltersAreAppliedInOrder(): void
    {
        $notification1 = new Notification();
        $notification1->setMessage('first');
        $notification2 = new Notification();
        $notification2->setMessage('second');
        $notification3 = new Notification();
        $notification3->setMessage('third');

        $envelopes = [
            new Envelope($notification1),
            new Envelope($notification2),
            new Envelope($notification3),
        ];

        $order = [];
        $criteria = new FilterCriteria([
            function ($e) use (&$order) {
                $order[] = 'first';

                return $e;
            },
            function ($e) use (&$order) {
                $order[] = 'second';

                return \array_slice($e, 0, 2);
            },
        ]);

        $result = $criteria->apply($envelopes);

        $this->assertSame(['first', 'second'], $order);
        $this->assertCount(2, $result);
    }

    public function testConstructorWithEmptyArrayDoesNotThrow(): void
    {
        // This test verifies the fix for uninitialized $callbacks property
        // Previously, new FilterCriteria([]) would leave $callbacks uninitialized
        // causing "must not be accessed before initialization" error on apply()
        $criteria = new FilterCriteria([]);

        $envelopes = [new Envelope(new Notification())];
        $result = $criteria->apply($envelopes);

        // With no callbacks, envelopes should pass through unchanged
        $this->assertSame($envelopes, $result);
    }

    public function testApplyWithEmptyCallbacksReturnsEnvelopesUnchanged(): void
    {
        $criteria = new FilterCriteria([]);

        $notification = new Notification();
        $notification->setMessage('test');
        $envelopes = [new Envelope($notification)];

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
        $this->assertSame('test', $result[0]->getMessage());
    }

    public function testApplyThrowsExceptionWhenCallbackReturnsNonArray(): void
    {
        $criteria = new FilterCriteria(fn ($e) => 'not an array');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Filter callback must return an array, got "string".');

        $criteria->apply([new Envelope(new Notification())]);
    }

    public function testApplyThrowsExceptionWhenCallbackReturnsNull(): void
    {
        $criteria = new FilterCriteria(fn ($e) => null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Filter callback must return an array, got "null".');

        $criteria->apply([new Envelope(new Notification())]);
    }

    public function testApplyThrowsExceptionWhenCallbackReturnsObject(): void
    {
        $criteria = new FilterCriteria(fn ($e) => new \stdClass());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Filter callback must return an array, got "stdClass".');

        $criteria->apply([new Envelope(new Notification())]);
    }
}
