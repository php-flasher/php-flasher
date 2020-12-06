<?php

namespace Flasher\SweetAlert\Prime\Factory;

final class SweetAlertProducer extends \Flasher\Prime\AbstractFlasher
{
    /**
     * @inheritDoc
     */
    public function getRenderer()
    {
        return 'sweet_alert';
    }

    /**
     * {@inheritdoc}
     */
    public function question($message, $title = '', $context = array(), array $stamps = array())
    {
        return $this->render('question', $message, $title, $context, $stamps);
    }

    public function image($title = '', $message = '', $imageUrl, $imageWidth = 400, $imageHeight = 200, $imageAlt = '', array $stamps = array())
    {
        $context['options']['title'] = $title;
        $context['options']['text'] = $message;
        $context['options']['imageUrl'] = $imageUrl;
        $context['options']['imageWidth'] = $imageWidth;
        $context['options']['imageHeight'] = $imageHeight;

        if (!is_null($imageAlt)) {
            $context['options']['imageAlt'] = $imageAlt;
        } else {
            $context['options']['imageAlt'] = $title;
        }

        $context['options']['animation'] = false;

        return $this->render('info', $message, $title, $context, $stamps);
    }
}
