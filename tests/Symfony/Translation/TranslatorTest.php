<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Translation;

use Flasher\Symfony\Translation\Translator;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\MessageCatalogueInterface;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;

final class TranslatorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&SymfonyTranslatorInterface $symfonyTranslatorMock;

    protected function setUp(): void
    {
        $this->symfonyTranslatorMock = \Mockery::mock(SymfonyTranslatorInterface::class);
        if (interface_exists(TranslatorBagInterface::class)) {
            $this->symfonyTranslatorMock->allows('getCatalogue')->andReturnUndefined();
        }
    }

    public function testTranslateWithoutTranslatorBagInterface(): void
    {
        $this->symfonyTranslatorMock->expects('trans')
            ->with('key', ['some_param' => 1], 'flasher', null)
            ->andReturns('translation');

        $translator = new Translator($this->symfonyTranslatorMock);
        $this->assertSame('translation', $translator->translate('key', ['some_param' => 1]));
    }

    public function testTranslateWithTranslatorBagInterfaceAndExistingTranslation(): void
    {
        $messageCatalogMock = \Mockery::mock(MessageCatalogueInterface::class);
        $messageCatalogMock->allows('has')->with('key', 'flasher')->andReturnTrue();

        $this->symfonyTranslatorMock->allows('getCatalogue')->andReturns($messageCatalogMock);
        $this->symfonyTranslatorMock->allows('trans')->with('key', ['some_param' => 1], 'flasher', null)->andReturns('translation');

        $translator = new Translator($this->symfonyTranslatorMock);
        $this->assertSame('translation', $translator->translate('key', ['some_param' => 1]));
    }

    public function testTranslateWithTranslatorBagInterfaceAndNonExistingTranslation(): void
    {
        $this->symfonyTranslatorMock->allows('getCatalogue')
            ->andReturnUsing(function () {
                $messageCatalogMock = \Mockery::mock(MessageCatalogueInterface::class);
                $messageCatalogMock->allows('has')->andReturnFalse();

                return $messageCatalogMock;
            });

        $this->symfonyTranslatorMock->allows('trans')
            ->with('key', ['some_param' => 1], 'flasher', null)
            ->andReturns('key');

        $translator = new Translator($this->symfonyTranslatorMock);
        $this->assertSame('key', $translator->translate('key', ['some_param' => 1]));
    }

    public function testGetLocale(): void
    {
        $this->symfonyTranslatorMock->allows('getLocale')->andReturns('en_US');

        $translator = new Translator($this->symfonyTranslatorMock);
        $this->assertSame('en_US', str_replace('_POSIX', '', $translator->getLocale()));
    }
}
