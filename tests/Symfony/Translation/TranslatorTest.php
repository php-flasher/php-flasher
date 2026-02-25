<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Translation;

use Flasher\Symfony\Translation\Translator;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\MessageCatalogueInterface;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;

final class TranslatorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testTranslateWithoutTranslatorBagInterface(): void
    {
        $symfonyTranslatorMock = \Mockery::mock(SymfonyTranslatorInterface::class);
        $symfonyTranslatorMock->expects('trans')
            ->with('key', ['some_param' => 1], 'flasher', null)
            ->andReturns('translation');

        $translator = new Translator($symfonyTranslatorMock);
        $this->assertSame('translation', $translator->translate('key', ['some_param' => 1]));
    }

    public function testTranslateWithoutTranslatorBagInterfaceAndLocale(): void
    {
        $symfonyTranslatorMock = \Mockery::mock(SymfonyTranslatorInterface::class);
        $symfonyTranslatorMock->expects('trans')
            ->with('key', [], 'flasher', 'fr')
            ->andReturns('traduction');

        $translator = new Translator($symfonyTranslatorMock);
        $this->assertSame('traduction', $translator->translate('key', [], 'fr'));
    }

    public function testTranslateWithTranslatorBagInterfaceFoundInFlasherDomain(): void
    {
        $messageCatalogMock = \Mockery::mock(MessageCatalogueInterface::class);
        $messageCatalogMock->expects('has')->with('key', 'flasher')->andReturnTrue();

        $symfonyTranslatorMock = \Mockery::mock(SymfonyTranslatorInterface::class, TranslatorBagInterface::class);
        $symfonyTranslatorMock->expects('getCatalogue')->with(null)->andReturns($messageCatalogMock);
        $symfonyTranslatorMock->expects('trans')->with('key', ['some_param' => 1], 'flasher', null)->andReturns('translation');

        $translator = new Translator($symfonyTranslatorMock);
        $this->assertSame('translation', $translator->translate('key', ['some_param' => 1]));
    }

    public function testTranslateWithTranslatorBagInterfaceFoundInMessagesDomain(): void
    {
        $messageCatalogMock = \Mockery::mock(MessageCatalogueInterface::class);
        $messageCatalogMock->expects('has')->with('key', 'flasher')->andReturnFalse();
        $messageCatalogMock->expects('has')->with('key', 'messages')->andReturnTrue();

        $symfonyTranslatorMock = \Mockery::mock(SymfonyTranslatorInterface::class, TranslatorBagInterface::class);
        $symfonyTranslatorMock->expects('getCatalogue')->with(null)->andReturns($messageCatalogMock);
        $symfonyTranslatorMock->expects('trans')->with('key', ['some_param' => 1], 'messages', null)->andReturns('translation from messages');

        $translator = new Translator($symfonyTranslatorMock);
        $this->assertSame('translation from messages', $translator->translate('key', ['some_param' => 1]));
    }

    public function testTranslateWithTranslatorBagInterfaceNotFoundReturnsId(): void
    {
        $messageCatalogMock = \Mockery::mock(MessageCatalogueInterface::class);
        $messageCatalogMock->expects('has')->with('key', 'flasher')->andReturnFalse();
        $messageCatalogMock->expects('has')->with('key', 'messages')->andReturnFalse();

        $symfonyTranslatorMock = \Mockery::mock(SymfonyTranslatorInterface::class, TranslatorBagInterface::class);
        $symfonyTranslatorMock->expects('getCatalogue')->with(null)->andReturns($messageCatalogMock);

        $translator = new Translator($symfonyTranslatorMock);
        $this->assertSame('key', $translator->translate('key', ['some_param' => 1]));
    }

    public function testTranslateWithTranslatorBagInterfaceAndSpecificLocale(): void
    {
        $messageCatalogMock = \Mockery::mock(MessageCatalogueInterface::class);
        $messageCatalogMock->expects('has')->with('greeting', 'flasher')->andReturnTrue();

        $symfonyTranslatorMock = \Mockery::mock(SymfonyTranslatorInterface::class, TranslatorBagInterface::class);
        $symfonyTranslatorMock->expects('getCatalogue')->with('de')->andReturns($messageCatalogMock);
        $symfonyTranslatorMock->expects('trans')->with('greeting', [], 'flasher', 'de')->andReturns('Hallo');

        $translator = new Translator($symfonyTranslatorMock);
        $this->assertSame('Hallo', $translator->translate('greeting', [], 'de'));
    }

    public function testGetLocaleWithGetLocaleMethod(): void
    {
        // Create a class that has getLocale method
        $symfonyTranslatorMock = new class implements SymfonyTranslatorInterface {
            public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
            {
                return $id;
            }

            public function getLocale(): string
            {
                return 'en_US';
            }
        };

        $translator = new Translator($symfonyTranslatorMock);
        $this->assertSame('en_US', str_replace('_POSIX', '', $translator->getLocale()));
    }

    public function testGetLocaleWithoutGetLocaleMethodUsesLocaleClass(): void
    {
        // Create a translator mock that doesn't have getLocale method
        $symfonyTranslatorMock = new class implements SymfonyTranslatorInterface {
            public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
            {
                return $id;
            }
        };

        $translator = new Translator($symfonyTranslatorMock);
        $locale = $translator->getLocale();

        // Should return a valid locale string (either from \Locale::getDefault() or 'en')
        $this->assertIsString($locale);
        $this->assertNotEmpty($locale);
    }

    public function testTranslateWithEmptyParameters(): void
    {
        $symfonyTranslatorMock = \Mockery::mock(SymfonyTranslatorInterface::class);
        $symfonyTranslatorMock->expects('trans')
            ->with('simple.message', [], 'flasher', null)
            ->andReturns('Simple Message');

        $translator = new Translator($symfonyTranslatorMock);
        $this->assertSame('Simple Message', $translator->translate('simple.message'));
    }

    public function testTranslateWithComplexParameters(): void
    {
        $parameters = [
            ':count' => 5,
            ':name' => 'John',
            ':resource' => 'users',
        ];

        $symfonyTranslatorMock = \Mockery::mock(SymfonyTranslatorInterface::class);
        $symfonyTranslatorMock->expects('trans')
            ->with('resource.created', $parameters, 'flasher', null)
            ->andReturns('5 users created by John');

        $translator = new Translator($symfonyTranslatorMock);
        $this->assertSame('5 users created by John', $translator->translate('resource.created', $parameters));
    }
}
