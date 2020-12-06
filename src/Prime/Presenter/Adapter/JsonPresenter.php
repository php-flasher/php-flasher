<?php

namespace Flasher\Prime\Presenter\Adapter;

use Flasher\Prime\Envelope;
use Flasher\Prime\Presenter\AbstractPresenter;

final class JsonPresenter extends AbstractPresenter
{
    /**
     * @param string|array $criteria
     *
     * @return array
     */
    public function render($criteria = null)
    {
        $filterName = 'default';

        if (is_string($criteria)) {
            $filterName = $criteria;
            $criteria   = array();
        }

        $envelopes = $this->getEnvelopes($filterName, $criteria);

        if (empty($envelopes)) {
            return array();
        }

        $response = array(
            'scripts'       => $this->getScripts($envelopes),
            'styles'        => $this->getStyles($envelopes),
            'options'       => $this->getOptions($envelopes),
            'notifications' => $this->renderEnvelopes($envelopes),
        );

        $this->storageManager->flush($envelopes);

        return $response;
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return array
     */
    private function renderEnvelopes($envelopes)
    {
        $notifications = array();

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Flasher\Prime\Stamp\HandlerStamp');
            $renderer      = $this->rendererManager->make($rendererStamp->getHandler());

            $notifications[] = array(
                'code'    => $renderer->render($envelope),
                'adapter' => $rendererStamp->getHandler()
            );
        }

        return $notifications;
    }
}
