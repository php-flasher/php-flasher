<?php

namespace Flasher\Laravel\Observer;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\FlasherInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Translation\Translator;

final class FlasherModelObserver
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var FlasherInterface
     */
    private $flasher;

    /**
     * @var Translator
     */
    private $translator;

    public function __construct(ConfigInterface $config, FlasherInterface $flasher, Translator $translator)
    {
        $this->config = $config;
        $this->flasher = $flasher;
        $this->translator = $translator;
    }

    /**
     * Handle the Model "created" event.
     *
     * @return void
     */
    public function created(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * Handle the Model "updated" event.
     *
     * @return void
     */
    public function updated(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * Handle the Model "deleted" event.
     *
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * Handle the Model "restored" event.
     *
     * @return void
     */
    public function restored(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * Handle the Model "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * @param string $method
     *
     * @return void
     */
    private function addFlash($method, Model $model)
    {
        $excludes = $this->config->get('observer_events.exclude', array());
        if (in_array($method, $excludes, true)) {
            return;
        }

        if (isset($excludes[$method]) && in_array(get_class($model), $excludes[$method], true)) {
            return;
        }

        if ($this->translator->has(sprintf('flasher::messages.flashable.%s.%s', get_class($model), $method))) {
            $message = $this->translator->get(sprintf('flasher::messages.flashable.%s.%s', get_class($model), $method));
        } else {
            $message = $this->translator->get(sprintf('flasher::messages.flashable.default.%s', $method));
            $replace = strrchr(get_class($model), '\\');
            if (false !== $replace) {
                $message = str_replace('{{ model }}', substr($replace, 1), $message);
            }
        }

        if (is_array($message)) {
            return;
        }

        $this->flasher->addSuccess($message);
    }
}
