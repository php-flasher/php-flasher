<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel;

use Flasher\Laravel\Translation\Translator;

final class TranslatorTest extends TestCase
{
    public function testTranslateMessage(): void
    {
        $translator = $this->getTranslator();

        $this->assertEquals('Success', $translator->translate('success', [], 'en'));
        $this->assertEquals('Succès', $translator->translate('success', [], 'fr'));
        $this->assertEquals('نجاح', $translator->translate('success', [], 'ar'));
    }

    public function testTranslateMessageWithParameters(): void
    {
        $translator = $this->getTranslator();

        $this->assertEquals('The :resource was created', $translator->translate('The resource was created', [], 'en'));
        $this->assertEquals('The user was created', $translator->translate('The resource was created', ['resource' => 'user'], 'en'));

        $this->assertEquals('La ressource :resource a été ajoutée', $translator->translate('The resource was created', [], 'fr'));
        $this->assertEquals('La ressource utilisateur a été ajoutée', $translator->translate('The resource was created', ['resource' => 'utilisateur'], 'fr'));

        $this->assertEquals('تم إنشاء :resource', $translator->translate('The resource was created', [], 'ar'));
        $this->assertEquals('تم إنشاء الملف', $translator->translate('The resource was created', ['resource' => 'الملف'], 'ar'));
    }

    private function getTranslator(): Translator
    {
        /** @var \Illuminate\Translation\Translator $laravelTranslator */
        $laravelTranslator = $this->app->make('translator');

        return new Translator($laravelTranslator);
    }
}
