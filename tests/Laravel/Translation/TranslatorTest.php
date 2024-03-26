<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Translation;

use Flasher\Laravel\Translation\Translator;
use Illuminate\Translation\Translator as LaravelTranslator;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class TranslatorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&LaravelTranslator $laravelTranslatorMock;

    protected function setUp(): void
    {
        $this->laravelTranslatorMock = \Mockery::mock(LaravelTranslator::class);
    }

    public function testTranslateWithExistingTranslation(): void
    {
        $this->laravelTranslatorMock->expects()
            ->has('flasher::messages.key', null)
            ->andReturnTrue();

        $this->laravelTranslatorMock->expects()
            ->get('flasher::messages.key', ['some_param' => 1], null)
            ->andReturns('translated message');

        $translator = new Translator($this->laravelTranslatorMock);
        $this->assertSame('translated message', $translator->translate('key', ['some_param' => 1]));
    }

    public function testTranslateWithFallbackTranslation(): void
    {
        $this->laravelTranslatorMock->expects()
            ->has('flasher::messages.key', null)
            ->andReturnFalse();

        $this->laravelTranslatorMock->expects()
            ->has('messages.key', null)
            ->andReturnTrue();

        $this->laravelTranslatorMock->expects()
            ->get('messages.key', ['some_param' => 1], null)
            ->andReturns('fallback translated message');

        $translator = new Translator($this->laravelTranslatorMock);
        $this->assertSame('fallback translated message', $translator->translate('key', ['some_param' => 1]));
    }

    public function testTranslateWithNoTranslationFound(): void
    {
        $this->laravelTranslatorMock->allows('has')
            ->andReturnFalse();

        $this->laravelTranslatorMock->allows('get')
            ->andReturnUsing(function ($id, $parameters, $locale) {
                return $id; // Simulate Laravel's behavior of returning the key when no translation is found
            });

        $translator = new Translator($this->laravelTranslatorMock);
        $this->assertSame('key', $translator->translate('key', ['some_param' => 1]));
    }

    public function testGetLocale(): void
    {
        $this->laravelTranslatorMock->expects()
            ->getLocale()
            ->andReturns('en');

        $translator = new Translator($this->laravelTranslatorMock);
        $this->assertSame('en', $translator->getLocale());
    }
}
