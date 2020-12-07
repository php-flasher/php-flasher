<?php

namespace Flasher\Laravel\Observer;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\FlasherInterface;
use Illuminate\Database\Eloquent\Model;

final class FlasherModelObserver
{
    /**
     * @var FlasherInterface
     */
    private $flasher;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param FlasherInterface $flasher
     * @param ConfigInterface  $config
     */
    public function __construct(FlasherInterface $flasher, ConfigInterface $config)
    {
        $this->flasher = $flasher;
        $this->config = $config;
    }

    /**
     * Handle the Model "created" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function created(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * Handle the Model "updated" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function updated(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * Handle the Model "deleted" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * Handle the Model "restored" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function restored(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * Handle the Model "force deleted" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function forceDeleted(Model $model)
    {
        $this->addFlash(__FUNCTION__, $model);
    }

    /**
     * @param string $method
     * @param Model  $model
     */
    private function addFlash(string $method, Model $model)
    {
        $message = $this->config->get(sprintf('flashable.%s.%s', get_class($model), $method));

        if(null === $message) {
            $message = $this->config->get(sprintf('flashable.default.%s', $method));
            $message = str_replace('{{ model }}', substr(strrchr(get_class($model), "\\"), 1), $message);
        }

        $this->flasher->addSuccess($message);
    }
}
