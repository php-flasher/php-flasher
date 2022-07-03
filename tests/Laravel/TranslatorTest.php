<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Laravel;

use Flasher\Laravel\Translation\Translator;

final class TranslatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testTranslateMessage()
    {
        $translator = $this->getTranslator();

        $this->assertEquals('Success', $translator->translate('success', array(), 'en'));
        $this->assertEquals('Succès', $translator->translate('success', array(), 'fr'));
        $this->assertEquals('نجاح', $translator->translate('success', array(), 'ar'));
    }

    /**
     * @return void
     */
    public function testTranslateMessageWithParameters()
    {
        $translator = $this->getTranslator();

        $this->assertEquals('The :resource was created', $translator->translate('The resource was created', array(), 'en'));
        $this->assertEquals('The user was created', $translator->translate('The resource was created', array('resource' => 'user'), 'en'));

        $this->assertEquals('La ressource :resource a été ajoutée', $translator->translate('The resource was created', array(), 'fr'));
        $this->assertEquals('La ressource utilisateur a été ajoutée', $translator->translate('The resource was created', array('resource' => 'utilisateur'), 'fr'));

        $this->assertEquals('تم إنشاء :resource', $translator->translate('The resource was created', array(), 'ar'));
        $this->assertEquals('تم إنشاء الملف', $translator->translate('The resource was created', array('resource' => 'الملف'), 'ar'));
    }

    /**
     * @return Translator
     */
    private function getTranslator()
    {
        /** @var \Illuminate\Translation\Translator $laravelTranslator */
        $laravelTranslator = $this->app->make('translator');

        return new Translator($laravelTranslator);
    }
}
