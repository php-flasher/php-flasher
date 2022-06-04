<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class FlasherListener
{
    /**
     * @var FlasherInterface
     */
    private $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    /**
     * @param ResponseEvent $event
     *
     * @return void
     */
    public function onKernelResponse($event)
    {
        $request = $event->getRequest();

        if (!$this->isMainRequest($event) || $request->isXmlHttpRequest() || !$request->hasSession()) {
            return;
        }

        $response = $event->getResponse();
        $content = $response->getContent() ?: '';

        $placeHolders = array(
            HtmlPresenter::FLASHER_FLASH_BAG_PLACE_HOLDER,
            HtmlPresenter::BODY_END_PLACE_HOLDER,
        );

        foreach ($placeHolders as $insertPlaceHolder) {
            $insertPosition = strripos($content, $insertPlaceHolder);
            if (false !== $insertPosition) {
                break;
            }
        }

        if (false === $insertPosition) {
            return;
        }

        $alreadyRendered = HtmlPresenter::FLASHER_FLASH_BAG_PLACE_HOLDER === $insertPlaceHolder;
        $htmlResponse = $this->flasher->render(array(), 'html', array('envelopes_only' => $alreadyRendered));

        if (empty($htmlResponse)) {
            return;
        }

        $content = substr($content, 0, $insertPosition).$htmlResponse.substr($content, $insertPosition + \strlen($insertPlaceHolder));
        $response->setContent($content);
    }

    /**
     * @param ResponseEvent $event
     *
     * @return bool
     */
    private function isMainRequest($event)
    {
        if (method_exists($event, 'isMainRequest')) {
            return $event->isMainRequest();
        }

        if (method_exists($event, 'isMasterRequest')) { // @phpstan-ignore-line
            return $event->isMasterRequest();
        }

        return 1 === $event->getRequestType();
    }
}
