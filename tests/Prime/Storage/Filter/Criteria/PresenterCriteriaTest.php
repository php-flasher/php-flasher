<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PresenterStamp;
use Flasher\Prime\Storage\Filter\Criteria\PresenterCriteria;
use PHPUnit\Framework\TestCase;

final class PresenterCriteriaTest extends TestCase
{
    public function testConstructorWithString(): void
    {
        $criteria = new PresenterCriteria('html');

        $this->assertInstanceOf(PresenterCriteria::class, $criteria);
    }

    public function testConstructorWithInvalidTypeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid type for criteria 'presenter'");

        new PresenterCriteria(123);
    }

    public function testConstructorWithNullThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid type for criteria 'presenter'");

        new PresenterCriteria(null);
    }

    public function testConstructorWithArrayThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid type for criteria 'presenter'");

        new PresenterCriteria(['html']);
    }

    public function testApplyFiltersByPresenterPattern(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PresenterStamp('/html/')]),
            new Envelope(new Notification(), [new PresenterStamp('/json/')]),
            new Envelope(new Notification(), [new PresenterStamp('/html/')]),
        ];

        $criteria = new PresenterCriteria('html');

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithExactMatch(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PresenterStamp('/^html$/')]),
            new Envelope(new Notification(), [new PresenterStamp('/^json$/')]),
        ];

        $criteria = new PresenterCriteria('html');

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyWithWildcardPattern(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PresenterStamp('/.*/')]),
            new Envelope(new Notification(), [new PresenterStamp('/html/')]),
        ];

        $criteria = new PresenterCriteria('anything');

        $result = $criteria->apply($envelopes);

        // Only the first envelope matches because /.*/ matches anything
        // The second requires 'html' in the presenter name
        $this->assertCount(1, $result);
    }

    public function testApplyFiltersEnvelopesWithoutPresenterStamp(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PresenterStamp('/html/')]),
            new Envelope(new Notification()),
            new Envelope(new Notification(), [new PresenterStamp('/json/')]),
        ];

        $criteria = new PresenterCriteria('html');

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithEmptyArray(): void
    {
        $criteria = new PresenterCriteria('html');

        $result = $criteria->apply([]);

        $this->assertSame([], $result);
    }

    public function testApplyWithCaseSensitivePattern(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PresenterStamp('/HTML/i')]),
            new Envelope(new Notification(), [new PresenterStamp('/html/')]),
        ];

        $criteria = new PresenterCriteria('html');

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithComplexPattern(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PresenterStamp('/^(html|json)$/i')]),
            new Envelope(new Notification(), [new PresenterStamp('/^html$/')]),
            new Envelope(new Notification(), [new PresenterStamp('/^json$/')]),
        ];

        $criteria = new PresenterCriteria('json');

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithNoMatch(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PresenterStamp('/html/')]),
            new Envelope(new Notification(), [new PresenterStamp('/json/')]),
        ];

        $criteria = new PresenterCriteria('html');

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
        $stamp = $result[0]->get(PresenterStamp::class);
        $this->assertSame('/html/', $stamp->getPattern());
    }

    public function testApplyWithInvalidPatternThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The provided regex pattern');

        $envelopes = [
            new Envelope(new Notification(), [new PresenterStamp('/invalid[/')]),
        ];

        $criteria = new PresenterCriteria('test');

        $criteria->apply($envelopes);
    }

    public function testApplyWithEmptyPresenter(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PresenterStamp('/html/')]),
            new Envelope(new Notification()),
        ];

        $criteria = new PresenterCriteria('');

        $result = $criteria->apply($envelopes);

        // Envelope without stamp uses default pattern /.*/ which matches empty string
        // Envelope with /html/ doesn't match empty string
        $this->assertCount(1, $result);
    }
}
